<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\MessageBag;

class CheckAdmin
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

        $Data = $request->only('level','freeze');
        
        //檢查資料
        $Error = $this->checkPost($Data);

        if ($Error) {

           return response()
                ->json([
                    'message' => $Error,
                    'status'  => 400,
                ],400);
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

        $Errors = '';

        $Num = ['1','2','3'];
        $Freeze = ['Y', 'N'];

        //判斷level格式
        if (!(in_array($Data['level'] ,$Num))) {

            $Errors = '請輸入正確格式';

        }

        //判斷Freeze格式
        if (!(in_array($Data['freeze'], $Freeze))) {

            $Errors = '請輸入正確格式';
            
        }

        //回傳
        return $Errors;
    }
}
