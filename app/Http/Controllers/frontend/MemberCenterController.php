<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\login;
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
        //
        // dd(session('account'));
        //列出帳號
        $User = login::
            select('uid', 'account', 'freeze', 'level', 'name', 'created_at', 'updated_at')
            ->where('account', session('account'))
            ->get();
            // print_r($User);
            // exit;
        return view( 'membercenter', ['User' => $User->makeHidden('attribute')->toArray()]);
        // echo "HELLO WORLD";
        // exit;
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
    public function show($id)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function updateuser(Request $request)
    {
        //
        $Msg = new MessageBag;

        $Data = $request->only('uid','name');

        //
        //檢查資料
        $Error = $this->checkUser($Data);

        //判斷是否有錯誤訊息
        if ($Error->any()) {
            return back()->withErrors($Error)->withInput();
        }

        $Reult = login::where('uid', $Data['uid'])
            // ->update(['votes' => 1]);
            ->update(['name' => $Data['name']]);
            // ->first();

        if(!$Reult){
            $Msg->add('messages', '修改失敗');
        }else{
            $Msg->add('messages', '修改成功');
        }

        return redirect('memberCenter')->withErrors($Msg);
        // print_r($Data['name']);
        // exit;
        // echo "AAAA";
        // exit;
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

    /**
     * Display the specified resource.
     *
     * @param  array  $Data
     * @return \Illuminate\Http\Response
     */
    public function checkUser($Data)
    {

        $Errors = new MessageBag;

        $Name = $Data['name'];

        //判斷名稱是否重複
        $User = login::select('Name')
            ->where('Name', $Name)
            ->first();

        //帳號是否存在
        if ($User['Name']) {

            $Errors->add('name', '名稱已存在');
        } 

        return $Errors;
    }
}
