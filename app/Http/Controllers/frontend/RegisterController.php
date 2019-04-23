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
        //
        return view('frontend.register');
        // return 'asdasd';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //資料
        $data = $request->all();
    
        //檢查資料
        $error = $this->checkUser($data);

        //判斷是否有錯誤訊息
        if($error != null){
            return back()->withErrors($error)->withInput();
        }
        

        //原生檢查的方式 == S ==
        $Auth = new Auth;

        $validator = Validator::make($data,$Auth->rules($data),$Auth->messages());

        if ($validator->fails()) {
            return redirect('/register')
                        ->withErrors($validator)
                        ->withInput();
        }
        //原生檢查的方式 == E ==

        //註冊
        $register = new register;

        // $NowTime=date("Y-m-d H:i:s");
        // $time = strtotime('Y-m-d H:i:s', $now);
        // $register->Uid = '';
        // $register->Level = '';
        //[a-zA-0-9]
        $register->account = $request->account;
        $register->password = base64_encode($request->password);
        $register->name = $request->name;
        // $register->Freeze = '';
        // $register->NewTime = $NowTime; 
        // $register->UpdateTime = '';

        $register->save();

        return redirect('/');
        // echo ($request);
        // exit;
        // return "sdasdads";
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
     * @param  array  $data
     * @return \Illuminate\Http\Response
     */
    public function checkUser($data)
    {
        
        $errors = new MessageBag;

        $Account = $data['account'];
        $Name = $data['name'];
        $Password = $data['password'];
        $Password2 = $data['password_confirmation'];


        //判斷帳號是否重複
             
        $User = DB::select('select Account , Name from user where Account = :Account' , ['Account' => $Account]);
        //轉換格式
        $User = json_encode($User);
        $User = json_decode($User , true);

        //判斷名稱是否重複
        
        $Name = DB::select('select name from user where Name = :Name', ['Name' => $Name]);
        //轉換格式
        $Name = json_encode($Name);
        $Name = json_decode($Name , true);

        //帳號是否存在
        if(count($User)>0){

            $errors->add('account','帳號已存在');         

        //名稱是否存在
        }elseif(count($Name)>0){

            $errors->add('name','名稱已存在');

        //密碼是否一致
        }elseif ($Password != $Password2) {        

            $errors->add('password','密碼需相同');

        }
        
        return $errors;
    }

}
