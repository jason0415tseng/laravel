<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\MessageBag;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAccountList()
    {
        //列出帳號
        $userList = Admin::select('uid', 'account', 'freeze', 'level', 'name', 'created_at', 'updated_at')
            ->where('level', '>', '0')
            ->where('account', '<>', session('account'))
            ->get()->toArray();

        return view('backend.admin', ['userList' => $userList]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function getAccount($user)
    {
        //列出帳號資訊
        $userData = Admin::select('uid', 'account', 'freeze', 'level', 'name')
            ->where('uid', $user)
            ->first();

        return view('backend.account', ['userData' => $userData]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAccount(Request $request)
    {
        $requestData = $request->only(['uid', 'level', 'freeze']);

        $updateUser = Admin::where('uid', $requestData['uid'])
            ->update([
                'level' => $requestData['level'],
                'freeze' => $requestData['freeze']
            ]);

        if ($updateUser) {
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
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteAccount(Request $request)
    {
        $errors = new MessageBag;

        $deleteUser = Admin::where('uid', $request['uid'])->delete();

        if ($deleteUser) {
            return redirect('admin');
        } else {
            $errors->add('messages', '修改失敗');
            return back()->withErrors($errors)->withInput();
        }
    }
}
