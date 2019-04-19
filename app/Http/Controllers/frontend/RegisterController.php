<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\register;
use Illuminate\Support\Facades\Validator;
// use Validator;

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
        // print_r($data);
        // exit;
        $messages = [
            'password.confirmed' => '密碼需相同',
        ];

        $validator = Validator::make($data, [
            'password' => 'required|confirmed',
            // 'password' => 'password == password_confirmation'
        ],$messages);

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
        $register->password = $request->password;
        $register->name = $request->name;
        // $register->Freeze = '';
        // $register->NewTime = $NowTime; 
        // $register->UpdateTime = '';

        $register->save();

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
}
