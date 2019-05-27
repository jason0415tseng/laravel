<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\movies;
use App\Models\order;
use App\Models\login;
use App\Models\time;
use Illuminate\Support\MessageBag;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMovieIndex()
    {
        //所有電影資料
        $movieData = movies::select('movies.Mid', 'movies.Name', 'movies.Name_en', 'movies.Ondate', 'movies.Grade', 'movies.Poster')
            ->join('time', 'movies.Mid', '=', 'time.Mid')
            ->where('display', '1')
            ->groupBy('movies.Mid', 'movies.Name', 'movies.Name_en', 'movies.Ondate', 'movies.Grade', 'movies.Poster')
            ->orderBy('ondate', 'ASC')
            ->get()->toArray();

        return view('frontend.movie', ['movieData' => $movieData]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getMovieDetail($id)
    {
        //電影時刻
        $movieTime = time::select('Time')
            ->where('Mid', $id)
            ->get()->toArray();

        //電影資料
        $movieData = movies::select(
            'movies.Mid',
            'movies.Name',
            'movies.Name_en',
            'movies.Ondate',
            'movies.Type',
            'movies.Length',
            'movies.Grade',
            'movies.Director',
            'movies.Actor',
            'movies.Poster',
            'movies.Introduction',
            'time.Hall'
        )
            ->join('time', 'movies.mid', '=', 'time.mid')
            ->where('movies.Mid', $id)
            ->first();

        if (!$movieData) {
            return redirect('/movie');
        } else {
            return view('frontend.moviedetail', ['movieData' => $movieData, 'movieTime' => $movieTime]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getMovieOrderPage($id)
    {
        //電影資料
        $movieData = movies::select('movies.Mid', 'movies.Name', 'time.Hall')
            ->join('time', 'movies.mid', '=', 'time.mid')
            ->where('movies.Mid', $id)
            ->first();

        //時刻&座位數
        $timeSeat = time::select('Time', 'Seat')
            ->where('Mid', $id)
            ->get()->toArray();

        if (!$movieData) {
            return redirect('/movie');
        } else {
            return view('frontend.movieorder', ['movieData' => $movieData, 'timeSeat' => $timeSeat]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function MovieOrderSelectSeat(Request $request, $id)
    {
        $errors = new MessageBag;

        $movieData['hall'] = $request->input('hall');
        $movieData['time'] = $request->input('time');
        $movieData['ticket'] = $request->input('ticket');

        //電影時刻&座位數
        $movieTime  = time::select('time', 'seat')
            ->where('mid', $id)
            ->where('time', $movieData['time'])
            ->first();

        //判斷時刻
        if (!$movieTime) {
            $errors->add('time', '時間錯誤');
            return back()->withErrors($errors)->withInput();
        }

        //剩餘票數 = 0
        if ($movieTime['seat'] == 0) {
            $errors->add('ticket', '目前無任何票可訂');
            return redirect('movie/order/' . $id)->withErrors($errors)->withInput();
        }

        //判斷數量
        if ($movieData['ticket'] < 0 || !(in_array($movieData['ticket'], ['1', '2', '3', '4']))) {
            $errors->add('ticket', '數量錯誤');
            return back()->withErrors($errors)->withInput();
        }

        //判斷剩餘票數
        if (($movieTime['seat'] - $movieData['ticket']) < 0) {
            $errors->add('ticket', '可訂票張數僅剩' . ($movieTime['seat']) . '位');
            return back()->withErrors($errors)->withInput();
        }

        //取帳號資訊
        $user = login::select('uid', 'name')
            ->where('account', session('account'))
            ->where('level', session('level'))
            ->first()->toArray();

        //取帳號已訂票資料
        $userOrder = order::select('*')
            ->where('orderuid', $user['uid'])
            ->where('ordermid', $id)
            ->where('ordertime', $movieData['time'])
            ->sum('orderticket');

        if ($userOrder) {
            //該帳號訂票數 = 4 
            if ($userOrder == 4) {
                $errors->add('ticket', '訂票數量已達上限');
                return back()->withErrors($errors)->withInput();
                //判斷數量
            } elseif (4 - $userOrder < $movieData['ticket']) {
                $errors->add('ticket', '可訂票張數僅剩' . (4 - $userOrder) . '位');
                return back()->withErrors($errors)->withInput();
            }
        }

        //電影名稱
        $movieName = movies::select('name')
            ->where('mid', $id)
            ->first();

        //取已訂票座位
        $orderSeat = order::select('orderseat')
            ->where('ordermid', $id)
            ->where('ordertime', $movieData['time'])
            ->get()->toArray();

        foreach ($orderSeat as $key => $value) {
            $orderSeat[$key] = explode(',', $value['orderseat']);
        }

        $orderSeat = array_flatten($orderSeat);

        $movieData['name'] = $movieName['name'];

        $movieData['mid'] = $id;

        if ($orderSeat) {
            return view('frontend.movieorderseat', ['movieData' => $movieData, 'orderSeat' => $orderSeat]);
        } else {
            return view('frontend.movieorderseat', ['movieData' => $movieData]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function createOrder(Request $request, $id)
    {
        $hall = $request->input('hall');
        $time = $request->input('time');
        $ticket = $request->input('ticket');
        $seat = $request->input('seat');

        //判斷數量是否與座位數相同
        if (count($seat) < $ticket) {
            return response()->json([
                'error'    => true,
                'messages' => '請選擇剩餘座位',
            ]);
        }

        if (count($seat) > $ticket) {
            return response()->json([
                'error'    => true,
                'status'   => 1,
                'messages' => '座位數錯誤',
            ]);
        }

        //判斷訂票數量
        if ($ticket < 0 || !(in_array($ticket, ['1', '2', '3', '4']))) {
            return response()->json([
                'error'    => true,
                'messages' => '數量錯誤',
            ]);
        }

        //取帳號資訊
        $user = login::select('uid', 'name')
            ->where('account', session('account'))
            ->where('level', session('level'))
            ->first()->toArray();

        //取帳號已訂票資料
        $userOrder = order::select('*')
            ->where('orderuid', $user['uid'])
            ->where('ordermid', $id)
            ->where('ordertime', $time)
            ->sum('orderticket');

        if ($userOrder) {
            if ($userOrder == 4) {
                return response()->json([
                    'error'    => true,
                    'messages' => '訂票數量已達上限',
                ]);
                //判斷數量
            } elseif (4 - $userOrder < $ticket) {
                return response()->json([
                    'error'    => true,
                    'status'   => 2,
                    'url'      => '/movie/order/' . $id,
                    'messages' => '可訂票張數僅剩' . (4 - $userOrder) . '位',
                ]);
            }
        }

        //取已訂票座位
        $orderSeat = order::select('orderseat')
            ->where('ordertime', $time)
            ->where('ordermid', $id)
            ->get()->toArray();

        if ($orderSeat) {
            foreach ($orderSeat as $key => $value) {
                $orderSeat[$key] = explode(',', $value['orderseat']);
            }

            $orderSeat = array_flatten($orderSeat);

            //判斷座位
            if (array_intersect($seat, $orderSeat)) {
                return response()->json([
                    'error'    => true,
                    'status'   => 1,
                    'messages' => '座位目前已被訂走，請重新選擇座位',
                ]);
            }
        }

        //新增
        $order = new order;
        $order->ordernumber = 'sn' . date('YmdHis');
        $order->ordermid = $id;
        $order->orderhall = $hall;
        $order->ordertime = $time;
        $order->orderticket = $ticket;
        $order->orderseat = implode(',', $seat);
        $order->orderuid = $user['uid'];
        $order->orderaccount = session('account');
        $order->ordername = $user['name'];

        //判斷剩餘票數
        $remainTicket = time::select('seat')
            ->where('mid', $id)
            ->where('time', $time)
            ->first();

        if (($remainTicket['seat'] - $ticket) < 0) {
            return response()->json([
                'error'    => true,
                'status'   => 2,
                'url'      => '/movie/order/' . $id,
                'messages' => '目前剩餘票數僅剩' . $remainTicket['seat'] . '張，請重新選擇票數',
            ]);
            return false;
        }

        if (($remainTicket['seat'] - $ticket) >= 0) {
            //更新DB
            $reuslt = time::where('Mid', $id)
                ->where('time', $time)
                ->decrement('seat', $order->orderticket);
            if (!$reuslt) {
                //回傳錯誤
                return response()->json([
                    'error'    => true,
                    'status'   => 2,
                    'url'      => '/movie/order/' . $id,
                    'messages' => '目前剩餘票數僅剩' . $remainTicket['seat'] . '張，請重新選擇票數',
                ]);
            }
        }

        //訂票
        $order->save();

        //判斷是否訂票成功
        if (!$order->save()) {
            //失敗把DB加回來
            time::where('Mid', $id)
                ->where('time', $time)
                ->increment('seat', $order->orderticket);
            //回傳錯誤
            return response()->json([
                'error'    => true,
                'status'   => 1,
                'messages' => "訂票失敗",
            ]);
        } else {
            //回傳成功
            return response()->json([
                'error'    => false,
                'messages' => "訂票成功!",
            ]);
        }
    }
}
