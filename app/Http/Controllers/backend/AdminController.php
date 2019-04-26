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
        //列出帳號
        $User = Admin::select('uid' , 'account', 'freeze', 'level', 'name' , 'created_at', 'updated_at')
                ->where('level','3')
                ->get();
        // print_r($User);
        // exit;
        // dd($User);
        return view('backend.admin',['User' => $User->makeHidden('attribute')->toArray()]);
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
        // print_r($User->makeHidden('attribute')->toArray());
        // exit;
        return view('backend.account', ['User' => $User->makeHidden('attribute')->toArray()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editaccount( Request $request)
    {
        //
        echo $request;
        exit;
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
