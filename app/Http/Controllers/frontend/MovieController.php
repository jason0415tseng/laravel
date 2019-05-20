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
        //列出資料
        $Data = movies::select('movies.Mid', 'movies.Name', 'movies.Name_en', 'movies.Ondate', 'movies.Grade', 'movies.Poster')
            ->join('time', 'movies.Mid', '=', 'time.Mid')
            ->where('display', '1')
            ->groupBy('movies.Mid', 'movies.Name', 'movies.Name_en', 'movies.Ondate', 'movies.Grade', 'movies.Poster')
            ->orderBy('ondate', 'ASC')
            ->get();
        return view('frontend.movie', ['Data' => $Data->makeHidden('attribute')->toArray()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getMovieDetail($id)
    {
        //
        $MovieTime = time::select('Time')
            ->where('Mid', $id)
            ->get()->toArray();

        $MovieData = movies::select(
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

        if (!$MovieData) {
            return redirect('/movie');
        } else {
            return view('frontend.moviedetail', ['MovieData' => $MovieData, 'MovieTime' => $MovieTime]);
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

        $MovieData = movies::select('movies.Mid', 'movies.Name', 'time.Hall')
            ->join('time', 'movies.mid', '=', 'time.mid')
            ->where('movies.Mid', $id)
            ->first();

        $TimeSeat = time::select('Time', 'Seat')
            ->where('Mid', $id)
            ->get()->toArray();

        if (!$MovieData) {
            return redirect('/movie');
        } else {
            return view('frontend.movieorder', ['MovieData' => $MovieData, 'TimeSeat' => $TimeSeat]);
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
        $Errors = new MessageBag;

        $Data = $request->all();
        $MovieTime  = time::select('Time', 'Seat')
            ->where('Mid', $id)
            ->where('Time', $Data['time'])
            ->first();

        if ($MovieTime['Seat'] == 0) {
            $Errors->add('ticket', '目前無任何票可訂');
            return redirect('movie/order/' . $id)->withErrors($Errors)->withInput();
        }

        //判斷時刻
        if (!$MovieTime) {
            $Errors->add('time', '時間錯誤');
            return back()->withErrors($Errors)->withInput();
        }

        //判斷數量
        if ($Data['ticket'] < 0) {
            $Errors->add('ticket', '數字錯誤');
            return back()->withErrors($Errors)->withInput();
        }
        if (!(in_array($Data['ticket'], ['1', '2', '3', '4']))) {
            //判斷範圍
            $Errors->add('ticket', '數量錯誤');
            return back()->withErrors($Errors)->withInput();
        }

        //判斷剩餘票數
        if (($MovieTime['Seat'] - $Data['ticket']) < 0) {
            $Errors->add('ticket', '可訂票張數僅剩' . ($MovieTime['Seat']) . '位');
            return back()->withErrors($Errors)->withInput();
        }

        //取帳號資訊
        $User = login::select('Uid', 'name')
            ->where('account', session('account'))
            ->where('level', session('level'))
            ->first()->toArray();

        //取帳號已訂票資料
        $UserOrder = order::select('*')
            ->where('orderuid', $User['Uid'])
            ->where('ordermid', $id)
            ->where('ordertime', $Data['time'])
            ->sum('orderticket');

        if ($UserOrder) {
            if ($UserOrder == 4) {
                $Errors->add('ticket', '訂票數量已達上限');
                return back()->withErrors($Errors)->withInput();
                //判斷數量
            } elseif (4 - $UserOrder < $Data['ticket']) {
                $Errors->add('ticket', '可訂票張數僅剩' . (4 - $UserOrder) . '位');
                return back()->withErrors($Errors)->withInput();
            }
        }

        $Reuslt = movies::select('Name')
            ->where('Mid', $id)
            ->first();

        $OrderSeat = order::select('OrderSeat')
            ->where('OrderMid', $id)
            ->where('OrderTime', $Data['time'])
            ->get()->toArray();
        // dd($OrderSeat);
        $Count = count($OrderSeat);

        $SeatList = [];

        for ($i = 0; $i < $Count; $i++) {
            $OrderSeat[$i]['OrderSeat'] = explode(',', $OrderSeat[$i]['OrderSeat']);
        }

        $SeatList = array_flatten($OrderSeat);

        $Data['name'] = $Reuslt->Name;

        $Data['mid'] = $id;

        if ($OrderSeat) {
            return view('frontend.movieorderseat', ['Data' => $Data, 'OrderSeat' => $SeatList]);
        } else {
            return view('frontend.movieorderseat', ['Data' => $Data]);
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
        $Errors = new MessageBag;

        $Data = $request->all();

        //判斷數量是否與座位數相同
        if (count($Data['seat']) != $Data['ticket']) {
            return response()->json([
                'error'    => true,
                'messages' => '請選擇剩餘座位',
            ]);
        }

        //判斷訂票數量
        if ($Data['ticket'] < 0) {
            $Errors->add('ticket', '數字錯誤');
            return back()->withErrors($Errors)->withInput();
        }

        if (!(in_array($Data['ticket'], ['1', '2', '3', '4']))) {
            //判斷範圍
            $Errors->add('ticket', '超過數量');
            return back()->withErrors($Errors)->withInput();
        }

        $Account = session('account');
        $Level = session('level');

        //取帳號資訊
        $User = login::select('Uid', 'name')
            ->where('account', $Account)
            ->where('level', $Level)
            ->first()->toArray();

        //取帳號已訂票資料
        $UserOrder = order::select('*')
            ->where('orderuid', $User['Uid'])
            ->where('ordermid', $id)
            ->where('ordertime', $Data['time'])
            ->sum('orderticket');

        if ($UserOrder) {
            if ($UserOrder == 4) {
                return response()->json([
                    'error'    => true,
                    'messages' => '訂票數量已達上限',
                ]);
                //判斷數量
            } elseif (4 - $UserOrder < $Data['ticket']) {
                return response()->json([
                    'error'    => true,
                    'status'   => 2,
                    'url'      => '/movie/order/' . $id,
                    'messages' => '可訂票張數僅剩' . (4 - $UserOrder) . '位',
                ]);
            }
        }

        //取已訂票座位
        $OrderSeat = order::select('OrderSeat')
            ->where('ordertime', $Data['time'])
            ->where('ordermid', $id)
            ->get()->toArray();

        if ($OrderSeat) {
            $Count = count($OrderSeat);

            $SeatList = [];
            for ($i = 0; $i < $Count; $i++) {
                $OrderSeat[$i]['OrderSeat'] = explode(',', $OrderSeat[$i]['OrderSeat']);
            }
            $SeatList = array_flatten($OrderSeat);

            //判斷座位
            if (array_intersect($Data['seat'], $SeatList)) {
                return response()->json([
                    'error'    => true,
                    'status'   => 1,
                    'messages' => '座位目前已被訂走，請重新選擇座位',
                ]);
            }
        }

        //新增
        $Order = new order;
        $Order->ordernumber = 'sn' . date('YmdHis');
        $Order->ordermid = $id;
        $Order->orderhall = $request->hall;
        $Order->ordertime = $request->time;
        $Order->orderticket = $request->ticket;
        $Order->orderseat = $request->seat;
        //轉換
        $Seat = $Order->orderseat;
        $Order->orderseat = implode(',', $Seat);
        $Order->orderuid = $User['Uid'];
        $Order->orderaccount = $Account;
        $Order->ordername = $User['name'];
        //判斷剩餘票數
        $RemainTicket = time::select('seat')
            ->where('mid', $id)
            ->where('time', $Data['time'])
            ->first();

        if (($RemainTicket['seat'] - $Data['ticket']) < 0) {
            return response()->json([
                'error'    => true,
                'status'   => 2,
                'url'      => '/movie/order/' . $id,
                'messages' => '目前剩餘票數僅剩' . $RemainTicket->seat . '張，請重新選擇票數',
            ]);
            return false;
        }
        if (($RemainTicket['seat'] - $Data['ticket']) >= 0) {
            //更新DB
            $Reuslt = time::where('Mid', $id)
                ->where('time', $Data['time'])
                ->decrement('seat', $Order->orderticket);
            if (!$Reuslt) {
                //回傳錯誤
                return response()->json([
                    'error'    => true,
                    'status'   => 2,
                    'url'      => '/movie/order/' . $id,
                    'messages' => '目前剩餘票數僅剩' . $RemainTicket->seat . '張，請重新選擇票數',
                ]);
            }
        }

        //訂票
        $Order->save();

        //判斷是否訂票成功
        if ($Order->save() === false) {
            //失敗把DB加回來
            time::where('Mid', $id)
                ->increment('seat', $Order->orderticket);
            //回傳錯誤
            return response()->json([
                'error'    => true,
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
