<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\login;
use DB;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('backend.login');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('/success');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //資料
        $Data = $request->only(['account', 'password']);

        //檢查資料
        $Error = $this->checkLogin($Data);

        if($Error->any()){
            return back()->withErrors($Error)->withInput();
        }

        $Account = $request->account;

        $request->session()->put('account',$Account);

        // return redirect('/index');
        return redirect('/success')->with([
            //跳轉資訊
            'Message'=>'恭喜登入，請您耐心等待！',
            //自己的跳轉路徑
            'Url' =>'/',
            //跳轉路徑名稱
            'UrlName' =>'首頁',
            //跳轉等待時間（s）
            'JumpTime'=>3,
     ]);
        
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

    /**
     * Display the specified resource.
     *
     * @param  array  $Data
     * @return \Illuminate\Http\Response
     */
    public function checkLogin($Data)
    {
        $Errors = new MessageBag;

        $Account = $Data['account'];
        $Password = base64_encode($Data['password']);

        $User = login::
                    select('account','password')
                    ->where('account', $Account)
                    ->where('password', $Password )
                    ->first();   


        if(!$User){
            $Errors->add('password','帳號或密碼錯誤');
        }

        return $Errors;

    }


    /**
     * Display the specified resource.
     *
     * @param  array  $data
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        //清除session
        $request->session()->flush();

        return redirect('/');

    }
}
