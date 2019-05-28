<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\login;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
{
    protected $Uid;
    protected $Account;
    protected $Level;
    protected $View = '';
    protected $Url = '';
    protected $UrlName = '';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        //
        return view('frontend.login');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSuccessPage()
    {
        return view('/success');
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
        $loginData = $request->only(['account', 'password']);

        //檢查資料
        $error = $this->CheckLogin($loginData);

        if ($error->any()) {
            return back()->withErrors($error)->withInput();
        }

        $request->session()->put('account', $this->Account);
        $request->session()->put('level', $this->Level);

        return redirect('/success')->with([
            //跳轉資訊
            'Message' => '恭喜登入，請您耐心等待！',
            //自己的跳轉路徑
            'Url' => $this->Url,
            //跳轉路徑名稱
            'UrlName' =>  $this->UrlName,
            //跳轉等待時間（s）
            'JumpTime' => 3,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  array  $loginData
     * @return \Illuminate\Http\Response
     */
    public function CheckLogin($loginData)
    {
        $errors = new MessageBag;

        $account = $loginData['account'];
        $password = base64_encode($loginData['password']);

        $userData = login::select('uid', 'account', 'password', 'freeze', 'level')
            ->where('account', $account)
            ->where('password', $password)
            ->first();

        if (!$userData) {
            $errors->add('password', '帳號或密碼錯誤');
        } elseif ($userData['freeze'] == 'N') {
            $errors->add('freeze', '目前帳號已被凍結');
        }

        $this->Level = $userData['level'];

        //判斷Level 設定訊息
        switch ($this->Level) {
            case '0':
                //Uid
                $this->Uid = $userData['uid'];
                //account
                $this->Account = $userData['account'];
                //自己的跳轉路徑
                $this->Url = '/admin';
                //跳轉路徑名稱
                $this->UrlName = '管理頁';
                break;
            case '1':
                //Uid
                $this->Uid = $userData['uid'];
                //account
                $this->Account = $userData['account'];
                //自己的跳轉路徑
                $this->Url = '/admin';
                //跳轉路徑名稱
                $this->UrlName = '管理頁';
                break;
            case '2':
                //Uid
                $this->Uid = $userData['uid'];
                //account
                $this->Account = $userData['account'];
                //自己的跳轉路徑
                $this->Url = '/admin';
                //跳轉路徑名稱
                $this->UrlName = '管理頁';
                break;
            case '3':
                //Uid
                $this->Uid = $userData['uid'];
                //account
                $this->Account = $userData['account'];
                //自己的跳轉路徑
                $this->Url = '/';
                //跳轉路徑名稱
                $this->UrlName = '首頁';
                break;
            default:
                break;
        }

        return $errors;
    }

    /**
     * Display the specified resource.
     *
     * @param  array  $Data
     * @return \Illuminate\Http\Response
     */
    public function CheckLevel($Data)
    {
        $errors = new MessageBag;

        $account = $Data['account'];
        $password = base64_encode($Data['password']);

        $userData = login::select('account', 'password', 'freeze', 'level')
            ->where('account', $account)
            ->where('password', $password)
            ->first();


        if (!$userData) {
            $errors->add('password', '帳號或密碼錯誤');
        } elseif ($userData['freeze'] == 'N') {
            $errors->add('freeze', '目前帳號已被凍結');
        }

        return $errors;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $Request)
    {
        //清除session
        $Request->session()->flush();

        return redirect('/');
    }
}
