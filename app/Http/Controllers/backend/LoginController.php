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
        return view('/index');
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
        $data = $request->all();

        //檢查資料
        $error = $this->checkLogin($data);

        if($error->any()){
            return back()->withErrors($error)->withInput();
        }

        $Account = $request->account;

        $request->session()->put('account',$Account);

        return redirect('/index');
        
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
     * @param  array  $data
     * @return \Illuminate\Http\Response
     */
    public function checkLogin($data)
    {
        $errors = new MessageBag;

        $Account = $data['account'];
        $Password = base64_encode($data['password']);

        $user = DB::table('user')
                    ->select('account','password')
                    ->where('account', $Account)
                    ->where('password', $Password )
                    ->first();   


        if(!$user){
            $errors->add('password','帳號或密碼錯誤');
        }

        return $errors;

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
