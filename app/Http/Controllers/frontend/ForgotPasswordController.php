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
    public function index()
    {
        //
        return view('frontend.forgot');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resetindex()
    {
        //
        return view('frontend.reset');
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetaccount(Request $request)
    {
        $Errors = new MessageBag;
        $Data = $request->only('account','name');
        $User = forgot::
                    select('uid','account','name','freeze')
                    ->where('account',$Data['account'])
                    ->where('name', $Data['name'])
                    ->first();
        
        if (!$User) {
            return back()->withErrors($Errors->add('name','查無帳號或名稱'))->withInput();
        } else {
            if(($User->freeze)== 'N'){
                return back()->withErrors($Errors->add('name', '此帳號目前凍結中'))->withInput();
            }else{
                return redirect('/password/reset')->with('User', $User->makeHidden('attribute')->toArray());
            }
        }
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
    public function reset(Request $request)
    {
        //
        $Data = $request->only('uid','account','password', 'password_confirmation');

        //原生檢查的方式 == S ==
        $Auth = new Auth;

        $Validator = Validator::make($Data, $Auth->forgotrules($Data), $Auth->messages());

        if ($Validator->fails()) {
            return redirect('/password/reset')
                ->withErrors($Validator)
                ->withInput();
        }
        //原生檢查的方式 == E ==

        $Password = base64_encode($Data['password']);

        $Result = forgot::
                where('uid', $Data['uid'])
                    ->update(['password' => $Password]);

        //修改完登入
        $User = forgot::
                select('account','level')
                    ->where('account', $Data['account'])
                    ->where('password', $Password )
                    ->first();

        $request->session()->put(['account' => $User['account'], 'level' => $User['level']]);

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
}
