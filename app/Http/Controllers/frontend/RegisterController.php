<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\register;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth;
use Illuminate\Support\Facades\DB;

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
        //驗證
        $data = $request->all();

        
        // $Auth->rules($data);
        // $User = $this->checkUser($data);
        // if(!$User){
        //     return false;
        // }
        // exit;
        // print_r($data);
        // exit;
        // $messages = [
        //     'password.confirmed' => '密碼需相同',
        // // ];
        $Auth = new Auth;

        $validator = Validator::make($data,$Auth->rules($data),$Auth->messages());

        
//         if($validator->fails()){
//             $errors = $validator->errors();
//             return back()->withErrors($validator);
// // print_r($errors->first('password'));
// // exit;
// //             echo $errors->first('password');
//             // return $errors;
//         }else{
//             return redirect()->route('/');
//         }

        if ($validator->fails()) {
            return redirect('/register')
                        ->withErrors($validator)
                        ->withInput();
        }

        //
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

        // $register->save();

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
        // print_r($data);
        // exit;
        //判斷帳號是否重複
        $Account = $data['account'];
        $Name = $data['name'];
        // echo $Account;
        // exit;
        $User = DB::select('select Account , Name from user where Account = :Account AND Name = :Name', ['Account' => $Account , 'Name' => $Name]);
        $User = json_encode($User);
        $User = json_decode($User , true);
        // foreach ($User as $user) {
        //     print_r($user);
        // }
        // dd($User);
       
//         if(empty($User[0])){
            // echo "AAAA";
//         }else{
//             echo "BBBBBBB";
//         }

        // $name = $data['name'];
        // $Name = DB::select('select name from user where name = :name', ['name' => $name]);

        // $Name = json_decode($Name , true);
// print_r($User);
// exit;
        if(!empty($User[0])){
            // print_r($User);
            // exit;
            // echo ('select Account from user where Account'). $Account;
            echo "AAAA";
            // return $errors->account('帳號已存在');
            // return $this->withErrors('required','帳號已存在');
            // echo '帳號已存在';
            // return view('/frontend.register',['account'=>'test']);
            $err= '帳號已存在';
            // exit;
            return ('/');
            // return view('frontend.register')->with('account','$err');
            // return back()->with('account',$err);
        // }else {
        //     if(!empty($Name[0])){
        //         // print_r($Name);
        //         // exit;
        //         // echo "BBBB";
        //     //判斷名稱是否重複
        //                     // return $errors->account('帳號已存在');
        //         // return $this->withErrors('required','帳號已存在');
        //         // echo '帳號已存在';
        //         // return view('/frontend.register',['account'=>'test']);
        //         $err= '名稱已存在';
        //         // return view('frontend.register')->with('account','$err');
        //         return back()->with('name',$err);
            
        //     }else{
        //         echo "CCCC";
        //         return true; 
        //     }
        }

        //帳號名稱都為空時才回傳正確
        // if($User =='' && $Name ==''){
        //     return true;
        // }
        // print_r($results);
        // exit;
        // echo "AAA/AAA";
        // exit;
        // print_r($data);
        // exit;
    }

}
