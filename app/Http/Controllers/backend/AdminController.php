<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use DB;
use Illuminate\Support\MessageBag;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Account = session('account');
        //列出帳號
        $User = Admin::select('uid', 'account', 'freeze', 'level', 'name', 'created_at', 'updated_at')
            ->where('level', '>', '0')
            ->where('account', '<>', $Account)
            ->get();
  
        return view('backend.admin', ['User' => $User->makeHidden('attribute')->toArray()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function getaccount($id)
    {
        //列出帳號資訊
        $User = Admin::select('uid', 'account', 'freeze', 'level', 'name')
            ->where('uid', $id)
            ->first();

        return view('backend.account', ['User' => $User->makeHidden('attribute')->toArray()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editaccount(Request $Request)
    {


        $User = $Request->only(['uid', 'level', 'freeze']);

        $User = Admin::where('uid', $User['uid'])

            ->update(['level' => $User['level'], 'freeze' => $User['freeze']]);

        if ($User) {
 
            return response()->json([
                'error' => false,
            ]);
        } else {

            return response()->json([
                'error'    => true,
                'messages' => '修改失敗',

            ]);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $Request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $Request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $Request
     * @return \Illuminate\Http\Response
     */
    public function deleteaccount(Request $Request)
    {
        $Errors = new MessageBag;

        $User = Admin::where('uid', $Request->uid)->delete();
        if ($User) {

            return redirect('admin');
        } else {

            $Errors->add('messages', '修改失敗');

            return back()->withErrors($Errors)->withInput();

        }

    }
}
