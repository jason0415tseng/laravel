<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\activity;
use App\Models\activitycontent;
use App\Models\vote;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\DB;

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
        $Data = activity::select('Aid', 'title', 'author', 'startdate', 'enddate')
            ->get()->toArray();

        //是否有投票
        $Voted = vote::select('voteaid', 'voteaccount')
            ->where('voteaccount', session('account'))
            ->get();

        //日期
        $Time = time();
        $NowTime = date('Y-m-d', $Time);

        foreach ($Data as $key => $value) {

            $Data[$key]['votenumber'] = DB::table('activitycontent')
                ->where('Aid', $value['Aid'])
                ->sum('votenumber');
        }

        if ($Voted) {
            return view('frontend.activity', ['Data' => $Data, 'Voted' => $Voted, 'NowTime' => $NowTime]);
        } else {
            return view('frontend.activity', ['Data' => $Data, 'NowTime' => $NowTime]);
        }
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

            foreach ($Data['content'] as $content) {

                //新增
                $Activitycontent = new Activitycontent;

                $Activitycontent->aid = $Aid->aid;
                $Activitycontent->content = $content;

                $Activitycontent->save();
            }

            return redirect('/activity');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        //
        $Title = activity::select('title', 'aid')
            ->where('aid', $id)
            ->first();

        $Data = activitycontent::select('acid', 'content')
            // ->join('activity','activity.aid','=','activitycontent.aid')
            ->where('aid', $id)
            ->get()->toArray();

        return view('frontend.activitydetail', ['Data' => $Data, 'Title' => $Title->makeHidden('attribute')->toArray()]);
    }

    /**
     * vote the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function vote(Request $request, $id)
    {
        $Errors = new MessageBag;

        $Data = $request->all();

        $Account = session('account');

        $Data = explode(',', $Data['acid']);
        //         foreach($Data as $date){
        //             $Data[] .= $date;
        // print_r($date);
        //         }
        // dd($Data[0]);


        $Content = activitycontent::select('*')
            ->where('acid', $Data[0])
            ->where('content', $Data[1])
            ->first();
        // dd($Content);
        //判斷選項
        if (!$Content) {
            $Errors->add('content', '選項錯誤');
            return back()->withErrors($Errors)->withInput();
        }

        //新增
        $Vote = new vote;
        $Vote->voteaid = $id;
        $Vote->voteacid = $Data[0];
        $Vote->voteaccount = $Account;
        $Vote->voteip = $request->getClientIp();

        $Vote->save();

        //更新投票數
        $UpdateVote = activitycontent::where('acid', $Data[0])
            ->increment('votenumber', '1');

        //         DB::table('posts')
        // ->where('id',1)
        // ->increment('words', 1);

        return redirect('/activity');
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
    public function voteresult($id)
    {
        $Title = activity::select('title', 'aid')
            ->where('aid', $id)
            ->first();

        $Data = activitycontent::select('acid', 'content', 'votenumber')
            // ->join('activity','activity.aid','=','activitycontent.aid')
            ->where('aid', $id)
            ->get()->toArray();

        $Total = DB::table('activitycontent')
            ->where('Aid', $id)
            ->sum('votenumber');
        // var_dump($Data[0]['votenumber']);
        // $Result = vote::select('acid')
        //     ->where('aid',$id)
        //     ->get()->toArray();

        return view('frontend.activityresult', ['Data' => $Data, 'Title' => $Title->makeHidden('attribute')->toArray(), 'Total' => $Total]);
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
