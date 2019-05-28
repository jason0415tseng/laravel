<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\movies;
use Illuminate\Support\MessageBag;

class MovieManagerController extends Controller
{
    protected $PathTime;
    protected $FileTime;

    /**
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        $this->PathTime = date('Ymd');
        $this->FileTime = date('YmdHis');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMovieList()
    {
        //列出資料
        $movieData = movies::select('*')
            ->where('display', '1')
            ->orderBy('ondate', 'ASC')
            ->get()->toArray();

        return view('backend.moviemanager', ['movieData' => $movieData]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createMovie(Request $request)
    {
        //圖片
        $picFile = $request->file('poster');

        //檢查圖片
        $error = $this->CheckPic($picFile);

        //判斷是否有錯誤訊息
        if ($error->any()) {
            return back()->withErrors($error)->withInput();
        }

        $fileName = $picFile->getClientOriginalName();

        // === 上傳圖片 === 
        $path = '../public/img/' . $this->PathTime;
        $newFileName = $this->FileTime . '_' . $fileName;
        if (!is_dir($path)) {
            mkdir($path, 0777);
        }
        $request->file('poster')->move($path, $newFileName);
        // === 上傳圖片 === 

        //新增
        $movies = new movies;

        $movies->name = $request->name;
        $movies->name_en = $request->name_en;
        $movies->ondate = $request->ondate;
        $movies->type = $request->type;
        $movies->length = $request->length;
        $movies->grade = $request->grade;
        $movies->director = $request->director;
        $movies->actor = $request->actor;
        $movies->poster = $this->PathTime . '/' . $newFileName;
        $movies->introduction = $request->introduction;

        $movies->save();

        return redirect('/moviemanager');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getMovie($id)
    {
        //列出資料
        $movieData = movies::select('*')
            ->where('Mid', $id)
            ->get()->toArray();

        return view('backend.movieedit', ['movieData' => $movieData]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMovie(Request $request, $id)
    {
        $errors = new MessageBag;

        $requestData = $request->all();

        //判斷片長
        if (($requestData['length'] < 60) || ($requestData['length'] > 240)) {
            $errors->add('length', '片長錯誤，範圍(60~240)');
            return back()->withErrors($errors)->withInput();
        }

        //圖片
        $picFile = $request->file('poster');

        //有上傳圖片
        if ($picFile) {
            //檢查圖片
            $error = $this->checkPic($picFile);

            //判斷是否有錯誤訊息
            if ($error->any()) {
                return back()->withErrors($error)->withInput();
            }

            //刪除舊圖
            $oldPoster = movies::select('poster')
                ->where('Mid', $id)
                ->first();

            // ==== 刪除圖片 ====
            $path = '../public/img/' . $oldPoster['poster'];
            unlink($path);
            // ==== 刪除圖片 ====

            //上傳新圖
            // === 上傳圖片 === 
            $fileName = $picFile->getClientOriginalName();
            $path = '../public/img/' . $this->PathTime;
            $newFileName = $this->FileTime . '_' . $fileName;
            if (!is_dir($path)) {
                mkdir($path, 0777);
            }
            $request->file('poster')->move($path, $newFileName);
            // === 上傳圖片 === 

            //更新
            $Result = movies::where('Mid', $id)
                ->update([
                    'name' => $requestData['name'],
                    'name_en' => $requestData['name_en'],
                    'ondate' => $requestData['ondate'],
                    'type' => $requestData['type'],
                    'length' => $requestData['length'],
                    'grade' => $requestData['grade'],
                    'director' => $requestData['director'],
                    'actor' => $requestData['actor'],
                    'introduction' => $requestData['introduction'],
                    'poster' => $this->PathTime . '/' . $newFileName,
                ]);

            return redirect('moviemanager');
        }

        //更新
        $Result = movies::where('Mid', $id)
            ->update([
                'name' => $requestData['name'],
                'name_en' => $requestData['name_en'],
                'ondate' => $requestData['ondate'],
                'type' => $requestData['type'],
                'length' => $requestData['length'],
                'grade' => $requestData['grade'],
                'director' => $requestData['director'],
                'actor' => $requestData['actor'],
                'introduction' => $requestData['introduction'],
            ]);

        return redirect('moviemanager');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     */
    public function deleteMovie($id)
    {
        $Result = movies::where('Mid', $id)
            ->update(['display' => '0']);

        return redirect('moviemanager');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAddPage()
    {
        return view('backend.movieadd');
    }

    /**
     * Display the specified resource.
     *
     * @param  array  $Data
     * @return \Illuminate\Http\Response
     */
    public function CheckPic($Data)
    {
        $errors = new MessageBag;

        $type = $Data->getClientOriginalExtension();
        $size = $Data->getSize();

        //確認上傳的檔案是否有效
        if (!($Data->isvalid())) {

            $errors->add('poster', '檔案無效');

            //確認上傳格式
        } elseif (!(in_array($type, ['jpeg', 'jpg', 'gif', 'png']))) {

            $errors->add('poster', '檔案格式錯誤');

            //確認檔案大小
        } elseif ($size > 1048576) {

            $errors->add('poster', '檔案大於1MB');
        }

        return $errors;
    }
}
