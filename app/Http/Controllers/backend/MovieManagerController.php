<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
// use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use App\Models\movies;
use Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth;
use Illuminate\Support\MessageBag;

class MovieManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //列出帳號
        $User = movies::select('*')
            // ->where('level', '>', '0')
            // ->where('account', '<>', $Account)
            ->get();

        // return view('backend.admin', ['User' => $User->makeHidden('attribute')->toArray()]);
        return view( 'backend.moviemanager', ['User' => $User->makeHidden('attribute')->toArray()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function movieadd(Request $request)
    {
        //
        // $Data = $request->all();

        $File = $request->file('poster');
        
        //檢查圖片
        $Error = $this->checkPic($File);
// exit;
// dd( $Error->any());
        //判斷是否有錯誤訊息
        if ($Error->any()) {
            return back()->withErrors($Error)->withInput();
        }
        // dd($Data);
        $FileName = $File->getClientOriginalName();

        $PathTime = date('Ymd');
        $FileTime = date('YmdHis');


        // ==== 刪除圖片 ====
        // $path = '../storage/app/img' . $time .'/' . $filename;
        // $url = unlink($path);
        // dd($url);
        // ==== 刪除圖片 ====

        // === 上傳圖片 === 
        $Path = '../public/img/' . $PathTime;
        $NewFileName = $FileTime . '_' . $FileName;
        if (!is_dir($Path)) {
            mkdir($Path, 0777);
        }
        $request->file('poster')->move($Path, $NewFileName);
        // === 上傳圖片 === 


        // ==== Storage刪除圖片 ====
        // $new_file = $time . '_' . $filename;
        // $path = 'img/' . $time . '/' . $new_file;
        // $bool = Storage::delete($path);
        // dd($bool);
        // ==== Storage刪除圖片 ====
        // dd($Data);

        // $data = $request->except('_token');
        // if ($request->file('photo')->isValid()) {
        //     //
        //     echo "失敗";
        //     exit;
        // }else{
        //     echo "成功";
        //     exit;
        // }
        // $size = $request->file('poster');
        // $size = $request->hasFile('poster');
        // dd( $file);
        // print_r($Data);
        // exit;

        //新增
        $Movies = new movies;

        $Movies->name = $request->name;
        $Movies->name_en = $request->name_en;
        $Movies->ondate = $request->ondate;
        $Movies->type = $request->type;
        $Movies->length = $request->length;
        $Movies->grade = $request->grade;
        $Movies->director = $request->director;
        $Movies->actor = $request->actor;
        $Movies->poster = $PathTime .'/'. $NewFileName;
        $Movies->introduction = $request->introduction;
        $Movies->seq = '1';

        $Movies->save();

        return redirect('/moviemanager');
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('backend.movieadd');
    }

    /**
     * Display the specified resource.
     *
     * @param  array  $Data
     * @return \Illuminate\Http\Response
     */
    public function checkPic($Data)
    {
        $Errors = new MessageBag;

        $Type = $Data->getClientOriginalExtension();
        $Size = $Data->getSize();
        
        //確認上傳的檔案是否有效
        if(!($Data->isvalid())){

            $Errors->add('poster','檔案無效');

        //確認上傳格式
        }elseif(!(in_array($Type,['jpeg','jpg','gif','png']))){

            $Errors->add('poster','檔案格式錯誤');

        //確認檔案大小
        }elseif($Size > 1048576){

            $Errors->add('poster','檔案大於1MB');

        }

        return $Errors;

        
        // echo 'File Name: ' . $Data->getClientOriginalName();
        // echo '<br>';
        // //Display File Extension
        // echo 'File Extension: ' . $Data->getClientOriginalExtension();
        // echo '<br>';

        // //Display File Real Path
        // echo 'File Real Path: ' . $Data->getRealPath();
        // echo '<br>';

        // //Display File Size
        // echo 'File Size: ' . $Data->getSize();
        // echo '<br>';

        // //Display File Mime Type
        // echo 'File Mime Type: ' . $Data->getMimeType();
        // exit;
    }
}
