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
    public function showActivityList()
    {
        //列出資料
        $activityData = activity::select('aid', 'title', 'author', 'startdate', 'enddate')
            ->get()->toArray();

        //是否有投票
        $voted = vote::select('voteaid', 'voteaccount')
            ->where('voteaccount', session('account'))
            ->get();

        //現在日期
        $time = time();
        $nowTime = date('Y-m-d', $time);

        //投票總數
        foreach ($activityData as $key => $value) {
            $activityData[$key]['votenumber'] = activitycontent::where('aid', $value['aid'])
                ->sum('votenumber');
        }

        if ($voted) {
            return view('frontend.activity', ['activityData' => $activityData, 'voted' => $voted, 'nowTime' => $nowTime]);
        } else {
            return view('frontend.activity', ['activityData' => $activityData, 'nowTime' => $nowTime]);
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

        $errors = new MessageBag;

        $title = $request->input('title');
        $content = $request->input('content');
        $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');

        //判斷標題
        $checkTitle = activity::select('*')
            ->where('title', $title)
            ->first();

        if ($checkTitle) {
            $errors->add('title', '已存在相同的活動囉!');
            return back()->withErrors($errors)->withInput();
        }

        //新增
        $activity = new Activity;
        $activity->title = $title;
        $activity->author = session('account');
        $activity->startdate = $startdate;
        $activity->enddate = $enddate;

        $activity->save();

        //判斷是否新增成功
        if (!$activity->save()) {
            //失敗
            $errors->add('title', '新增失敗');
            return back()->withErrors($errors)->withInput();
        } else {
            //成功後撈取id
            $titleAid = activity::select('aid')
                ->where('title', $title)
                ->where('author', session('account'))
                ->first();

            foreach ($content as $content) {
                //新增
                $activitycontent = new Activitycontent;
                $activitycontent->aid = $titleAid['aid'];
                $activitycontent->content = $content;

                $activitycontent->save();
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
        //活動標題
        $activityTitle = activity::select('title', 'aid')
            ->where('aid', $id)
            ->first();

        //選項內容
        $activityContent = activitycontent::select('acid', 'content')
            ->where('aid', $id)
            ->get()->toArray();

        return view('frontend.activitydetail', ['activityTitle' => $activityTitle, 'activityContent' => $activityContent]);
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
        $errors = new MessageBag;

        //傳送資料
        $requestData = explode(',', $request->input('acid'));

        //判斷選項
        $checkContent = activitycontent::select('*')
            ->where('acid', $requestData[0])
            ->where('content', $requestData[1])
            ->first();

        if (!$checkContent) {
            $errors->add('content', '選項錯誤');
            return back()->withErrors($errors)->withInput();
        }

        //更新投票數
        $updateVote = activitycontent::where('acid', $requestData[0])
            ->increment('votenumber', '1');

        if (!$updateVote) {
            $errors->add('content', '投票更新失敗，請重新投票');
            return back()->withErrors($errors)->withInput();
        }

        //新增
        $vote = new vote;
        $vote->voteaid = $id;
        $vote->voteacid = $requestData[0];
        $vote->voteaccount = session('account');
        $vote->voteip = $request->getClientIp();

        $vote->save();

        //判斷是否投票成功
        if (!$vote->save()) {
            //失敗把DB扣回來
            activitycontent::where('acid', $requestData[0])
                ->decrement('votenumber', '1');
            //回傳錯誤
            $errors->add('content', '投票失敗，請重新投票');
            return back()->withErrors($errors)->withInput();
        }

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
        //活動標題
        $activityTitle = activity::select('title', 'aid')
            ->where('Aid', $id)
            ->first();

        //活動選項&投票數
        $activityContentData = activitycontent::select('acid', 'content', 'votenumber')
            ->where('Aid', $id)
            ->get()->toArray();

        //總投票數
        $total = activitycontent::where('Aid', $id)
            ->sum('votenumber');

        if (($total == 0) ? $total =  1 : $total);

        foreach ($activityContentData as $key => $value) {
            $activityContentData[$key]['rate'] = (round($value["votenumber"] / $total, 2) * 100);
        }

        return view('frontend.activityresult', ['activityTitle' => $activityTitle, 'activityContentData' => $activityContentData]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showActivity($id)
    {
        //活動詳細資料
        $activity = activity::select('title', 'aid', 'startdate', 'enddate')
            ->where('aid', $id)
            ->first();

        //選項資料
        $content = activitycontent::select('acid', 'content')
            ->where('aid', $id)
            ->get()->toArray();

        return view('frontend.activityeditor', ['activity' => $activity, 'content' => $content]);
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
        $errors = new MessageBag;

        $title = $request->input('title');
        $content = $request->input('content');
        $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');

        //判斷標題
        $checkTitle = activity::select('*')
            ->where('title', $title)
            ->where('aid', '<>', $id)
            ->first();

        if ($checkTitle) {
            $errors->add('title', '已存在相同的活動囉 !');
            return back()->withErrors($errors)->withInput();
        }

        //判斷選項
        foreach ($content as $contentData) {
            if (!$contentData) {
                $errors->add('content', '選項內容請勿留空 !');
                return back()->withErrors($errors)->withInput();
            }
        }

        //判斷開始時間
        $activityStartDate = activity::select('startdate')
            ->where('aid', $id)
            ->first();

        if ($startdate < $activityStartDate['startdate']) {
            $errors->add('startdate', '開始時間請勿小於原本設定時間 !');
            return back()->withErrors($errors)->withInput();
        }

        //判斷結束時間
        if ($enddate < $startdate) {
            $errors->add('enddate', '結束時間請勿小於開始時間 !');
            return back()->withErrors($errors)->withInput();
        }

        //刪除選項
        if ($request->input('delete')) {
            foreach ($request->input('delete') as $delete) {
                //判斷是否有該選項
                $activityContentData = activitycontent::select('*')
                    ->where('acid', $delete)
                    ->where('aid', $id)
                    ->first();
                if (!$activityContentData) {
                    $errors->add('content', '選項有誤 !');
                    return back()->withErrors($errors)->withInput();
                } else {
                    //刪除選項
                    activitycontent::where('acid', $delete)
                        ->delete();
                    //刪除投票
                    vote::where('voteacid', $delete)
                        ->delete();
                }
            }
        }

        //新增選項
        if ($request->input('create')) {
            foreach ($request->input('create') as $create) {
                if (!$create) {
                    $errors->add('content', '選項內容請勿留空 !');
                    return back()->withErrors($errors)->withInput();
                } else {
                    //新增選項
                    $activitycontent = new Activitycontent;
                    $activitycontent->aid = $id;
                    $activitycontent->content = $create;

                    $activitycontent->save();
                }
            }
        }

        //更新活動
        $updateActivity = activity::where('aid', $id)
            ->update([
                'title' => $request->input('title'),
                'startdate' => $request->input('startdate'),
                'enddate' => $request->input('enddate'),
            ]);

        if (!$updateActivity) {
            $errors->add('title', '更新失敗 !');
            return back()->withErrors($errors)->withInput();
        } else {
            foreach ($content as $key => $value) {
                //更新選項
                activitycontent::where('acid', $key)
                    ->where('aid', $id)
                    ->update(['content' => $value]);
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
        $activity = activity::select('*')
            ->where('Aid', $id);

        $activityContent = activitycontent::select('*')
            ->where('Aid', $id);

        $vote = vote::select('*')
            ->where('VoteAid', $id);

        //刪除活動&選項&投票
        $activity->delete();
        $activityContent->delete();
        $vote->delete();

        return redirect('/activity');
    }
}
