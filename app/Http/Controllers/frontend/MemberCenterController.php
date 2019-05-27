<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\login;
use App\Models\order;
use Illuminate\Support\MessageBag;

class MemberCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //帳號資料
        $userData = login::select('uid', 'account', 'freeze', 'level', 'name', 'created_at')
            ->where('account', session('account'))
            ->first();
        return view('frontend.membercenter', ['userData' => $userData]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrderInfo()
    {
        //列出帳號
        $orderList = order::select('movies.name', 'order.ordernumber', 'order.orderhall', 'order.ordertime', 'order.orderticket', 'order.orderseat', 'order.orderaccount', 'order.ordername', 'order.created_at', 'order.updated_at')
            ->join('movies', 'movies.mid', '=', 'order.ordermid')
            ->where('orderaccount', session('account'))
            ->get()->toArray();

        foreach ($orderList as $key => $value) {
            $orderList[$key]['orderseat'] .= ',';
            $orderList[$key]['orderseat'] = str_replace(['_', ','], ['排', '號</br>'], $orderList[$key]['orderseat']);
        }
        // dd($orderList);
        if (!$orderList) {
            return view('frontend.orderinfo');
        } else {
            return view('frontend.orderinfo', ['orderList' => $orderList]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request)
    {
        $msg = new MessageBag;

        $requestData = $request->only('uid', 'name');

        //檢查資料
        $error = $this->CheckUser($requestData);

        //判斷是否有錯誤訊息
        if ($error->any()) {
            return back()->withErrors($error)->withInput();
        }

        $Reult = login::where('uid', $requestData['uid'])
            ->update(['name' => $requestData['name']]);

        if (!$Reult) {
            $msg->add('messages', '修改失敗');
        } else {
            $msg->add('messages', '修改成功');
        }

        return redirect('membercenter')->withErrors($msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  array  $Data
     * @return \Illuminate\Http\Response
     */
    public function CheckUser($Data)
    {

        $errors = new MessageBag;

        $name = $Data['name'];

        //判斷名稱是否重複
        $userName = login::select('name')
            ->where('name', $name)
            ->first();

        //帳號是否存在
        if ($userName['name']) {

            $errors->add('name', '名稱已存在');
        }

        return $errors;
    }
}
