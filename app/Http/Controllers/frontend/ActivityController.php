<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\activity;
use App\Models\activitycontent;
use Illuminate\Support\MessageBag;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //列出資料
        // $Data = activity::select('activity.title', 'activity.author', 'activity.startdate', 'activity.enddate', activity::raw('SUM(activitycontent.votenumber)as votenumber'))
        $Data = activity::select('activity.title', 'activity.author', 'activity.startdate', 'activity.enddate')
            ->join('activitycontent', 'activitycontent.Aid', '=', 'activity.Aid')
            ->sum('activitycontent.votenumber');
        // ->sum('activitycontent.votenumber');
        // ->where('display', '1')
        // ->orderBy('ondate', 'ASC')
        // ->get();
        dd($Data);

        return view('frontend.activity', ['Data' => $Data->makeHidden('attribute')->toArray()]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('frontend.activityadd');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function activityadd(Request $request)
    {

        $Errors = new MessageBag;

        $Data = $request->all();
        // dd($Data['title']);
        $Account = session('account');

        //判斷標題
        $Title = activity::select('*')
            ->where('title', $Data['title'])
            ->first();

        if ($Title) {
            $Errors->add('title', '已存在相同的活動囉!');
            return back()->withErrors($Errors)->withInput();
        }

        //新增
        $Activity = new Activity;

        $Activity->title = $Data['title'];
        $Activity->author = $Account;
        $Activity->startdate = $Data['startdate'];
        $Activity->enddate = $Data['enddate'];

        $Activity->save();

        //判斷是否訂票成功
        if ($Activity->save() === false) {
            //失敗
            $Errors->add('title', '新增失敗');
            return back()->withErrors($Errors)->withInput();
        } else {
            //成功後撈取id
            $Aid = activity::select('aid')
                ->where('title', $Data['title'])
                ->where('author', $Account)
                ->first();
            // dd($Aid->aid);

            foreach ($Data['content'] as $content) {

                //新增
                $Activitycontent = new Activitycontent;

                $Activitycontent->aid = $Aid->aid;
                $Activitycontent->content = $content;

                $Activitycontent->save();
            }

            return redirect('/');
            // $Activitycontent->save();
        }
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
