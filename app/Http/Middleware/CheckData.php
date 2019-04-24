<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\MessageBag;

class CheckData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //資料
        $data = $request->all();
        
        //檢查資料
        $error = $this->checkPost($data);

        //判斷有錯導回
        if($error->any()){
            return back()->withErrors($error)->withInput();
        }
        
        return $next($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  array  $data
     * @return \Illuminate\Http\Response
     */
    public function checkPost($data)
    {
        
        $errors = new MessageBag;

        $Account = $data['account'];
        
        $Password = $data['password'];
        
        //判斷帳號格式
        if(!(preg_match('/^[a-zA-Z]+[\d]+$|[\d]+[a-zA-Z]+$/', $Account))){

            $errors->add('account','請輸入正確格式');

             
        }
        //判斷密碼格式
        if(!(preg_match('/^[a-zA-Z]+[\d]+$|[\d]+[a-zA-Z]+$/', $Password))){
            
            $errors->add('password','請輸入正確格式');

        }

        //回傳
        return $errors;
    }
}
