<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\forgot;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth;

class ForgotPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showForgotForm()
    {
        //
        return view('frontend.forgot');
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getResetAccount(Request $request)
    {
        $errors = new MessageBag;
        $requestData = $request->only('account', 'name');
        $userData = forgot::select('uid', 'account', 'name', 'freeze')
            ->where('account', $requestData['account'])
            ->where('name', $requestData['name'])
            ->first();

        if (!$userData) {
            return back()->withErrors($errors->add('name', '查無帳號或名稱'))->withInput();
        } else {
            if (($userData['freeze']) == 'N') {
                return back()->withErrors($errors->add('name', '此帳號目前凍結中'))->withInput();
            } else {
                return redirect('/password/reset')->with('userData', $userData->makeHidden('attribute')->toArray());
            }
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showResetForm()
    {
        //
        return view('frontend.reset');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAccountPassword(Request $request)
    {
        $requestData = $request->only('uid', 'account', 'password', 'password_confirmation');

        //原生檢查的方式 == S ==
        $auth = new Auth;

        $validator = Validator::make($requestData, $auth->forgotrules($requestData), $auth->messages());

        if ($validator->fails()) {
            return redirect('/password/reset')
                ->withErrors($validator)
                ->withInput();
        }
        //原生檢查的方式 == E ==

        $password = base64_encode($requestData['password']);

        forgot::where('uid', $requestData['uid'])
            ->update(['password' => $password]);

        //修改完登入
        $userData = forgot::select('account', 'level')
            ->where('account', $requestData['account'])
            ->where('password', $password)
            ->first();

        $request->session()->put(['account' => $userData['account'], 'level' => $userData['level']]);

        return redirect('/success')->with([
            //跳轉資訊
            'Message' => '恭喜登入，請您耐心等待！',
            //自己的跳轉路徑
            'Url' => '/',
            //跳轉路徑名稱
            'UrlName' =>  '首頁',
            //跳轉等待時間（s）
            'JumpTime' => 3,
        ]);
    }
}
