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
                    select('uid','account','name')
                    ->where('account',$Data['account'])
                    ->where('name', $Data['name'])
                    ->where('level','3')
                    ->first();
        
// print_r($User->uid);
// exit;
        if (!$User) {
            return back()->withErrors($Errors->add('name','查無帳號或名稱'))->withInput();
        } else {
            // echo "OK";
            // exit;
            $User->toArray();
            return view('frontend.reset')->with(['uid'=> $User->uid , 'account'=> $User->account]);
        }
        // print_r($User);
        // exit;
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
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        // $Data = $request->all();
        // print_r($Data);
        // exit;
        $Data = $request->only('uid','account','password', 'password_confirmation');
        // print_r($Data);
        // exit;
        // print_r($request->uid);
        // print_r("\n");
        // print_r($request->account);
        // exit;


        //原生檢查的方式 == S ==
        $Auth = new Auth;

        $Validator = Validator::make($Data, $Auth->rules($Data), $Auth->messages());
        // echo "ASDASD";
        // exit;
// print_r($Validator);
// exit;
        if ($Validator->fails()) {

            // dd(back());
            // return redirect()->back()
            return view('frontend.reset')
                ->withErrors($Validator)
                ->withInput($request->only('uid','account'));
        }
        //原生檢查的方式 == E ==
        // print_r($Data);
        // exit;
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
}
