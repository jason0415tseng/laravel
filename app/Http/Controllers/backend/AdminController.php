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
        $User = Admin::select('uid', 'account', 'freeze', 'level', 'name', 'created_at', 'updated_at')
            ->where('level', '>', '0')
            ->get();
        // print_r($User);
        // exit;
        // dd($User);
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
    public function editaccount(Request $request)
    {
        // $Errors = new MessageBag;

        $User = $request->only(['uid', 'level', 'freeze']);
        // print_r($User);
        // exit;
        $User = Admin::where('uid', $User['uid'])
            // ->update(['votes' => 1]);
            ->update(['level' => $User['level'], 'freeze' => $User['freeze']]);

        // ->where('password', $Password )

        // ->get();
        if ($User) {
            // return view('backend.admin');
            // $this->index();
            return response()->json([
                'error' => false,
            ]);
        } else {
            //     echo "AAAA";
            //     exit;
            return response()->json([
                'error'    => true,
                'messages' => '修改失敗',
                // $Errors->add( 'messages', '修改失敗'),
            ]);
        }
        // print_r($User);
        // exit;
        // return response()->json(['success'=>'Got Simple Ajax Request.']);

        // return view('backend.admin');
        //資料
        // print_r($request->only(['uid','level', 'freeze']));
        // exit;
        // $Data = $request->only(['uid','level', 'freeze']);
        // print_r($Data);
        // exit;
        // $User = Admin::
        //             // ->update(['votes' => 1]);

        //             where('uid', $Data['uid'])
        //             // ->where('password', $Password )
        //             // update('level', $Data['level'],'freeze', $Data['freeze'])
        //             ->first();
        // print_r($User);
        // exit;
        // echo $request;
        // exit;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteaccount(Request $request)
    {
        $Errors = new MessageBag;
        //
        $User = Admin::where('uid',$request->uid)->delete();
        if($User){
            // return response()->json([
            //     'error' => false,
            // ]);
            // return view('backend.admin');
            // return $this->index();
            return redirect('admin');
        } else {
            //     echo "AAAA";
            //     exit;
            // return response()->json([
            //     'error'    => true,
            //     'messages' => '刪除失敗',
            $Errors->add( 'messages', '修改失敗');
            // ]);
            return back()->withErrors($Errors)->withInput();
            // return back()->$Errors->add( 'messages', '刪除失敗');
        }
        // print_r($User);
        // exit;
        // $Data = $request->all();
        // print_r($Data);
        // exit;
    }
}
