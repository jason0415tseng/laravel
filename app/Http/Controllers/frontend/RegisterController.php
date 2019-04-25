<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\register;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //資料
        $Data = $request->all();
    
        //檢查資料
        $Error = $this->checkUser($Data);

        //判斷是否有錯誤訊息
        if($Error->any()){
            return back()->withErrors($Error)->withInput();
        }
        

        //原生檢查的方式 == S ==
        $Auth = new Auth;

        $Validator = Validator::make($Data,$Auth->rules($Data),$Auth->messages());

        if ($Validator->fails()) {
            return redirect('/register')
                        ->withErrors($Validator)
                        ->withInput();
        }
        //原生檢查的方式 == E ==

        //註冊
        $Register = new register;

        $Register->account = $request->account;
        $Register->password = base64_encode($request->password);
        $Register->name = $request->name;


        $Register->save();

        //註冊完登入
        $request->session()->put('account', $Register->account);

        return redirect('/success');

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
    public function checkUser($Data)
    {
        
        $Errors = new MessageBag;

        $Account = $Data['account'];
        $Name = $Data['name'];
        $Password = $Data['password'];
        $Password2 = $Data['password_confirmation'];

        //判斷帳號、名稱是否重複
        $User = register::
                    select('Account' , 'Name')
                    ->where('Account' , $Account)
                    ->orwhere('Name' , $Name)
                    ->first();

        //帳號是否存在
        if($User['Account']){

            $Errors->add('account','帳號已存在');         

        //名稱是否存在
        }elseif($User['Name']){

            $Errors->add('name','名稱已存在');

        //密碼是否一致
        }elseif ($Password != $Password2) {        

            $Errors->add('password','密碼需相同');

        }
        
        return $Errors;
    }

}
