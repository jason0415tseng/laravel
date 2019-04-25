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
        $Data = $request->only(['account', 'password']);
        
        //檢查資料
        $Error = $this->checkPost($Data);

        //判斷有錯導回
        if($Error->any()){
            return back()->withErrors($Error)->withInput();
        }
        
        return $next($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  array  $Data
     * @return \Illuminate\Http\Response
     */
    public function checkPost($Data)
    {
        
        $Errors = new MessageBag;
        
        //判斷帳號格式
        if(!(preg_match('/^[a-zA-Z]+[\d]+$|[\d]+[a-zA-Z]+$/', $Data['account']))){

            $Errors->add('account','請輸入正確格式');
             
        }
        //判斷密碼格式
        if(!(preg_match('/^[a-zA-Z]+[\d]+$|[\d]+[a-zA-Z]+$/', $Data['password']))){
            
            $Errors->add('password','請輸入正確格式');

        }

        //回傳
        return $Errors;
    }
}
