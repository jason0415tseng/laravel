<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\register;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegisterForm()
    {
        return view('frontend.register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {
        //資料
        $requestData = $request->all();

        //原生檢查的方式 == S ==
        $auth = new Auth;

        $validator = Validator::make($requestData, $auth->rules($requestData), $auth->messages());

        if ($validator->fails()) {
            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        }
        //原生檢查的方式 == E ==

        //註冊
        $register = new register;

        $register->account = $request->account;
        $register->password = base64_encode($request->password);
        $register->name = $request->name;

        $register->save();

        //註冊完登入
        $request->session()->put('account', $register->account);
        $request->session()->put('level', '3');

        return redirect('/success');
    }
}
