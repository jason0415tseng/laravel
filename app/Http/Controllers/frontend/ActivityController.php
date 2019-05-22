<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\activity;
use App\Models\activitycontent;
use App\Models\vote;
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
            $Data[$key]['votenumber'] = activitycontent::where('Aid', $value['Aid'])
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
    public function showActivityAdd()
    {
        return view('frontend.activityadd');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createActivityAdd(Request $request)
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

        //判斷是否新增成功
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
    public function showActivityDetail($id)
    {
        $Title = activity::select('title', 'aid')
            ->where('aid', $id)
            ->first();

        $Data = activitycontent::select('acid', 'content')
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
    public function createVote(Request $request, $id)
    {
        $Errors = new MessageBag;

        $Data = $request->all();

        $Account = session('account');

        $Data = explode(',', $Data['acid']);

        $Content = activitycontent::select('*')
            ->where('acid', $Data[0])
            ->where('content', $Data[1])
            ->first();

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

        return redirect('/activity');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showVoteResult($id)
    {
        $Title = activity::select('title', 'aid')
            ->where('Aid', $id)
            ->first();

        $Data = activitycontent::select('acid', 'content', 'votenumber')
            ->where('Aid', $id)
            ->get()->toArray();

        $Total = activitycontent::where('Aid', $id)
            ->sum('votenumber');

        return view('frontend.activityresult', ['Data' => $Data, 'Title' => $Title->makeHidden('attribute')->toArray(), 'Total' => $Total]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showActivity($id)
    {
        $Activity = activity::select('title', 'aid', 'startdate', 'enddate')
            ->where('aid', $id)
            ->first();

        $Content = activitycontent::select('acid', 'content')
            ->where('aid', $id)
            ->get()->toArray();

        return view('frontend.activityeditor', ['Activity' => $Activity, 'Content' => $Content]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateActivity(Request $request, $id)
    {
        $Errors = new MessageBag;

        //判斷標題
        $Title = activity::select('*')
            ->where('title', $request->input('title'))
            ->where('aid', '<>', $id)
            ->first();

        if ($Title) {
            $Errors->add('title', '已存在相同的活動囉 !');
            return back()->withErrors($Errors)->withInput();
        }

        //判斷選項
        $Content = $request->input('content');
        foreach ($Content as $content) {
            if (!$content) {
                $Errors->add('content', '選項內容請勿留空 !');
                return back()->withErrors($Errors)->withInput();
            }
        }

        //判斷開始時間
        $Activity = activity::select('title', 'aid', 'startdate', 'enddate')
            ->where('aid', $id)
            ->first();

        if ($request->input('startdate') < $Activity['startdate']) {
            $Errors->add('startdate', '開始時間請勿小於原本設定時間 !');
            return back()->withErrors($Errors)->withInput();
        }

        //判斷結束時間
        if ($request->input('enddate') < $request->input('startdate')) {
            $Errors->add('enddate', '結束時間請勿小於開始時間 !');
            return back()->withErrors($Errors)->withInput();
        }

        //刪除選項
        if ($request->input('delete')) {
            foreach ($request->input('delete') as $delete) {
                $Data = activitycontent::select('*')
                    ->where('acid', $delete)
                    ->where('aid', $id)
                    ->first();
                if (!$Data) {
                    $Errors->add('content', '選項有誤 !');
                    return back()->withErrors($Errors)->withInput();
                } else {
                    activitycontent::where('acid', $delete)
                        ->delete();
                    vote::where('voteacid', $delete)
                        ->delete();
                }
            }
        }

        //更新活動
        $Result = activity::where('Aid', $id)
            ->update([
                'title' => $request->input('title'),
                'startdate' => $request->input('startdate'),
                'enddate' => $request->input('enddate'),
            ]);

        if ($Result == false) {
            $Errors->add('title', '更新失敗 !');
            return back()->withErrors($Errors)->withInput();
        } else {
            foreach ($Content as $key => $value) {
                //更新選項
                $ContentResult = activitycontent::where('ACid', $key)
                    ->where('Aid', $id)
                    ->update([
                        'content' => $value,
                    ]);

                if ($ContentResult == false) {
                    //新增
                    $Activitycontent = new Activitycontent;
                    $Activitycontent->aid = $id;
                    $Activitycontent->content = $value;

                    $Activitycontent->save();
                }
            }
        }

        return redirect('/activity');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyActivity($id)
    {
        $Activity = activity::select('*')
            ->where('Aid', $id);

        $ActivityContent = activitycontent::select('*')
            ->where('Aid', $id);

        $Vote = vote::select('*')
            ->where('VoteAid', $id);

        $Activity->delete();
        $ActivityContent->delete();
        $Vote->delete();

        return redirect('/activity');
    }
}
