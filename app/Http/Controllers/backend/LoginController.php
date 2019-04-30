<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\login;
use DB;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
{

    protected $Uid;
    protected $Account;
    protected $Level;
    protected $View = '';
    // protected $Message = '';
    protected $Url = '';
    protected $UrlName = '';

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
        return view('/success');
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
        $Data = $request->only(['account', 'password']);

        //檢查資料
        $Error = $this->CheckLogin($Data);

        if($Error->any()){
            return back()->withErrors($Error)->withInput();
        }

        // print_r($this->Level);
        // exit;
        //判斷是否為管理者
        // $Level = $this->CheckLevel( $Data);
        // $View = '';
        // $Message = '';
        // $Url = '';
        // $UrlName = '';

        // $Account = $request->account;

        $request->session()->put('account',$this->Account);
        $request->session()->put('level', $this->Level);

        // return redirect('/index');
        return redirect('/success')->with([
            //跳轉資訊
            'Message'=>'恭喜登入，請您耐心等待！',
            //自己的跳轉路徑
            'Url' => $this->Url ,
            //跳轉路徑名稱
            'UrlName' =>  $this->UrlName ,
            //跳轉等待時間（s）
            'JumpTime'=>3,
     ]);
        
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
    public function CheckLogin($Data)
    {
        $Errors = new MessageBag;

        $Account = $Data['account'];
        $Password = base64_encode($Data['password']);

        $User = login::
                    select('uid','account','password','freeze','level')
                    ->where('account', $Account)
                    ->where('password', $Password )
                    ->first();

        if(!$User){
            $Errors->add('password','帳號或密碼錯誤');
        }elseif($User['freeze'] == 'N'){
            $Errors->add('freeze','目前帳號已被凍結');
        }

        $this->Level = $User['level'];

        //判斷Level 設定訊息
        switch($this->Level){
            case '0':
                //Uid
                $this->Uid = $User['uid'];
                //account
                $this->Account = $User[ 'account'];
                //跳轉資訊
                // $this->Message = '恭喜登入，請您耐心等待！';
                //自己的跳轉路徑
                $this->Url = '/admin';
                //跳轉路徑名稱
                $this->UrlName = '管理頁';
                break;
            case '1':
                //Uid
                $this->Uid = $User['uid'];
                //account
                $this->Account = $User['account'];
                //跳轉資訊
                // $this->Message = '恭喜登入，請您耐心等待！';
                //自己的跳轉路徑
                $this->Url = '/admin';
                //跳轉路徑名稱
                $this->UrlName = '管理頁';
                break;
            case '2':
                //Uid
                $this->Uid = $User['uid'];
                //account
                $this->Account = $User['account'];
                //跳轉資訊
                // $this->Message = '恭喜登入，請您耐心等待！';
                //自己的跳轉路徑
                $this->Url = '/admin';
                //跳轉路徑名稱
                $this->UrlName = '管理頁';
                break;
            case '3':
                //Uid
                $this->Uid = $User['uid'];
                //account
                $this->Account = $User['account'];
                //跳轉資訊
                $this->Message = '恭喜登入，請您耐心等待！';
                //自己的跳轉路徑
                $this->Url = '/';
                //跳轉路徑名稱
                $this->UrlName = '首頁';
                break;
            default:
                break;
        }

        return $Errors;

    }

    /**
     * Display the specified resource.
     *
     * @param  array  $Data
     * @return \Illuminate\Http\Response
     */
    public function CheckLevel($Data)
    {
        $Errors = new MessageBag;

        $Account = $Data['account'];
        $Password = base64_encode($Data['password']);

        $User = login::select('account', 'password', 'freeze', 'level')
            ->where('account', $Account)
            ->where('password', $Password)
            ->first();


        if (!$User) {
            $Errors->add('password', '帳號或密碼錯誤');
        } elseif ($User['freeze'] == 'N') {
            $Errors->add('freeze', '目前帳號已被凍結');
        }

        return $Errors;
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
