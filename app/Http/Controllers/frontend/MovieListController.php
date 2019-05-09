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

        //判斷席位數
        if ($Data['seat'] < 0) {

            $Errors->add('seat', '席位數字錯誤');
            return back()->withErrors($Errors)->withInput();
        } elseif (!(preg_match('/[1-4]/', $Data['seat']))) {

            //判斷範圍
            $Errors->add('seat', '席位數超過數量');
            return back()->withErrors($Errors)->withInput();
        }
        // if (preg_match('/[1-4]/', $Data['seat'])) {
        //     echo "YES";
        //     exit;
        // } else {
        //     echo "NO";
        //     exit;
        // }
        // dd($Data);
        // if ($Data['seat'] > 2) {
        //     $Errors->add('seat', '席位數超過數量');
        //     return back()->withErrors($Errors)->withInput();
        // }

        $Account = session('account');
        $Level = session('level');

        $User = forgot::select('Uid', 'name')
            ->where('account', $Account)
            ->where('level', $Level)
            ->first()->toArray();


        $Order = order::select('*')
            ->where('orderuid', $User['Uid'])
            ->where('ordermid', $id)
            ->first();
        // dd($Order['OrderSeat']);
        if ($Order) {
            //判斷人數
            if ((($Order['OrderSeat']) - ($Data['seat'])) >= 0) {
                switch ((($Order['OrderSeat']) - ($Data['seat']))) {
                    case '1':
                        $Errors->add('seat', '席位數僅剩3位');
                        return back()->withErrors($Errors)->withInput();
                        break;
                    case '2':
                        $Errors->add('seat', '席位數僅剩2位');
                        return back()->withErrors($Errors)->withInput();
                        break;
                    case '3':
                        $Errors->add('seat', '席位數僅剩1位');
                        return back()->withErrors($Errors)->withInput();
                        break;
                    case '0':
                        $Errors->add('seat', '席位已達上限');
                        return back()->withErrors($Errors)->withInput();
                        break;
                    default:
                        break;
                }
            }
            // switch (abs(($Data['seat']) - ($Order['OrderSeat']))) {
            switch ($Order['OrderSeat']) {
                case '1':
                    $Errors->add('seat', '席位數僅剩3位');
                    return back()->withErrors($Errors)->withInput();
                    break;
                case '2':
                    $Errors->add('seat', '席位數僅剩2位');
                    return back()->withErrors($Errors)->withInput();
                    break;
                case '3':
                    $Errors->add('seat', '席位數僅剩1位');
                    return back()->withErrors($Errors)->withInput();
                    break;
                case '4':
                    $Errors->add('seat', '席位已達上限');
                    return back()->withErrors($Errors)->withInput();
                    break;
                default:
                    break;
            }

            // if ($Order['OrderSeat'] = 1) {
            //     $Errors->add('seat', '席位數僅剩1位');
            //     return back()->withErrors($Errors)->withInput();
            // } else {
            //     $Errors->add('seat', '席位數已達上限');
            //     return back()->withErrors($Errors)->withInput();
            // }
        }

        //新增
        $Order = new order;

        $Order->ordernumber = 'sn' . date('YmdHis');
        $Order->ordermid = $id;

        $Order->orderhall = $request->hall;
        $Order->orderdate = $request->date;
        $Order->orderseat = $request->seat;

        $Order->orderuid = $User['Uid'];
        $Order->orderaccount = $Account;
        $Order->ordername = $User['name'];

        $Order->save();

        //判斷是否訂票成功
        if ($Order->save() === false) {
            //失敗
            $Errors->add('seat', '訂票失敗');
            return back()->withErrors($Errors)->withInput();
        } else {
            //成功後更新DB
            $Reuslt = time::where('Mid', $id)
                // ->update(['seat' => ('seat-' . ($Order->orderseat))]);
                ->decrement('seat', $Order->orderseat);
        }

        return redirect('/movielist');
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
