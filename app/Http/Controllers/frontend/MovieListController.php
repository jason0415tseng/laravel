<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\movies;
use App\Models\order;
use App\Models\forgot;
use App\Models\time;
use Illuminate\Support\MessageBag;
use PhpParser\Node\Stmt\Switch_;

class MovieListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //列出資料
        $Data = movies::select('*')
            ->join('time', 'movies.Mid', '=', 'time.Mid')
            ->where('display', '1')
            ->orderBy('ondate', 'ASC')
            ->get();

        return view('frontend.movielist', ['Data' => $Data->makeHidden('attribute')->toArray()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        //
        $Order = order::select('*')
            ->where('ordermid', $id)
            ->first();
        // dd($Order);
        // if ($Order) {
        //     $Data = movies::select('*')
        //         ->join('order', 'movies.mid', '=', 'ordermid')
        //         ->join('time', 'movies.mid', '=', 'time.mid')
        //         ->where('movies.Mid', $id)
        //         ->get()->toArray();

        //     $Data[0]['Date'] = explode(',', $Data[0]['Date']);
        //     // dd($Data);
        // } else {
        $Data = movies::select('*')
            ->join('time', 'movies.mid', '=', 'time.mid')
            ->where('movies.Mid', $id)
            ->get();

        $Data = $Data->toArray();
        $Data[0]['Date'] = explode(',', $Data[0]['Date']);
        // }


        return view('frontend.moviedetail', ['Data' => $Data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function order($id)
    {

        $Data = movies::select('movies.Mid', 'movies.Name', 'time.Hall', 'time.Date')
            ->join('time', 'movies.mid', '=', 'time.mid')
            ->where('movies.Mid', $id)
            ->get();

        $Data = $Data->toArray();

        $Data[0]['Date'] = explode(',', $Data[0]['Date']);


        return view('frontend.movieorder', ['Data' => $Data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function orderseat(Request $request, $id)
    {
        $Data = $request->all();

        // echo "AAAAA";

        $Reuslt = movies::select('Name')
            // ->join('time', 'movies.mid', '=', 'time.mid')
            ->where('Mid', $id)
            ->first();
        $Data['name'] = $Reuslt->Name;

        $Data['mid'] = $id;

        for ($i = 1; $i <= 20; $i++) {
            $Seat[] = $i;
        }
        // print_r($Data);
        // exit;
        // $Data = $Data->toArray();

        // $Data[0]['Date'] = explode(',', $Data[0]['Date']);


        return view('frontend.movieorderseat', ['Data' => $Data, 'Seat' => $Seat]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function orderadd(Request $request, $id)
    {
        $Errors = new MessageBag;

        $Data = $request->all();
        // print_r($Data);
        // exit;
        //判斷數量
        if ($Data['ticket'] < 0) {

            $Errors->add('ticket', '數字錯誤');
            return back()->withErrors($Errors)->withInput();
        } elseif (!(preg_match('/[1-4]/', $Data['ticket']))) {

            //判斷範圍
            $Errors->add('ticket', '超過數量');
            return back()->withErrors($Errors)->withInput();
        }

        $Account = session('account');
        $Level = session('level');

        $User = forgot::select('Uid', 'name')
            ->where('account', $Account)
            ->where('level', $Level)
            ->first()->toArray();

        $OrderSeat = order::select('*')
            ->where('orderuid', $User['Uid'])
            ->where('ordermid', $id)
            ->sum('OrderTicket');

        if ($OrderSeat == 4) {

            // $Errors->add('seat', '數量已達上限');
            // return back()->withErrors($Errors)->withInput();
            return response()->json([
                'error'    => true,
                'messages' => '數量已達上限',

            ]);

            //判斷數量
        } elseif (4 - $OrderSeat < $Data['seat']) {
            print_r("AAA");
            exit;
            $Errors->add('seat', '張數僅剩' . (4 - $OrderSeat) . '位');
            return back()->withErrors($Errors)->withInput();
        }

        //新增
        $Order = new order;

        $Order->ordernumber = 'sn' . date('YmdHis');
        $Order->ordermid = $id;

        $Order->orderhall = $request->hall;
        $Order->orderdate = $request->date;
        $Order->orderticket = $request->ticket;
        $Order->orderseat = $request->seat;
        //轉換
        $Seat = $Order->orderseat;
        $Order->orderseat = implode(',', $Seat);

        $Order->orderuid = $User['Uid'];
        $Order->orderaccount = $Account;
        $Order->ordername = $User['name'];

        print_r($Order->orderseat);
        exit;
        return response()->json([
            'error'    => true,
            'messages' => "c8 8c8 8c 8c",

        ]);
        // dd($Order->orderseat);
        // $Order->save();

        //判斷是否訂票成功
        // if ($Order->save() === false) {
        //     //失敗
        //     $Errors->add('seat', '訂票失敗');
        //     return back()->withErrors($Errors)->withInput();
        // } else {
        //     //成功後更新DB
        //     $Reuslt = time::where('Mid', $id)
        //         ->decrement('seat', $Order->orderseat);
        // }

        // return redirect('/movielist');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
