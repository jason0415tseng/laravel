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
    public function index()
    {
        //列出資料
        $Data = movies::select('*')
            ->where('display', '1')
            ->orderBy('ondate', 'ASC')
            // ->where('level', '>', '0')
            // ->where('account', '<>', $Account)
            ->get();

        // return view('backend.admin', ['User' => $User->makeHidden('attribute')->toArray()]);
        return view('backend.moviemanager', ['Data' => $Data->makeHidden('attribute')->toArray()]);
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
        //圖片
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

        // $PathTime = date('Ymd');
        // $FileTime = date('YmdHis');


        // ==== 刪除圖片 ====
        // $path = '../storage/app/img' . $time .'/' . $filename;
        // $url = unlink($path);
        // dd($url);
        // ==== 刪除圖片 ====

        // === 上傳圖片 === 
        $Path = '../public/img/' . $this->PathTime;
        $NewFileName = $this->FileTime . '_' . $FileName;
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
        $Movies->poster = $this->PathTime . '/' . $NewFileName;
        $Movies->introduction = $request->introduction;

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
    public function getmovie($id)
    {
        //
        //列出資料
        $Data = movies::select('*')
            ->where('id', $id)
            // ->where('account', '<>', $Account)
            ->get();

        return view('backend.movieedit', ['Data' => $Data->makeHidden('attribute')->toArray()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function movieedit(Request $request, $id)
    {
        $Data = $request->all();
        // print_r($Data);
        // print_r($id);
        // exit;
        //圖片
        $File = $request->file('poster');

        //有上傳圖片
        if ($File) {

            //檢查圖片
            $Error = $this->checkPic($File);

            //判斷是否有錯誤訊息
            if ($Error->any()) {
                return back()->withErrors($Error)->withInput();
            }

            //刪除舊圖
            $Poster = movies::select('poster')
                ->where('id', $id)
                ->first();
            // print_r($Path['poster']);
            // ==== 刪除圖片 ====
            $Path = '../public/img/' . $Poster['poster'];
            unlink($Path);
            // $url = unlink($Path);
            // dd($url);
            // ==== 刪除圖片 ====

            //上傳新圖
            // === 上傳圖片 === 
            $FileName = $File->getClientOriginalName();
            $Path = '../public/img/' . $this->PathTime;
            $NewFileName = $this->FileTime . '_' . $FileName;
            if (!is_dir($Path)) {
                mkdir($Path, 0777);
            }
            $request->file('poster')->move($Path, $NewFileName);
            // === 上傳圖片 === 

            //更新
            $Result = movies::where('id', $id)
                ->update([
                    'name' => $Data['name'],
                    'name_en' => $Data['name_en'],
                    'ondate' => $Data['ondate'],
                    'type' => $Data['type'],
                    'length' => $Data['length'],
                    'grade' => $Data['grade'],
                    'director' => $Data['director'],
                    'actor' => $Data['actor'],
                    'introduction' => $Data['introduction'],
                    'poster' => $this->PathTime . '/' . $NewFileName,
                ]);

            return redirect('moviemanager');
        }
        // dd($File);
        //更新
        $Result = movies::where('id', $id)
            ->update([
                'name' => $Data['name'],
                'name_en' => $Data['name_en'],
                'ondate' => $Data['ondate'],
                'type' => $Data['type'],
                'length' => $Data['length'],
                'grade' => $Data['grade'],
                'director' => $Data['director'],
                'actor' => $Data['actor'],
                'introduction' => $Data['introduction'],
            ]);

        // if (!$Result) {
        //     $Msg = ('messages', '修改失敗');
        // } else {
        //     $Msg = ('messages', '修改成功');
        // }
        return redirect('moviemanager');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     */
    public function moviedelete($id)
    {
        //
        // echo "AAAAAAA";
        // exit;

        $Result = movies::where('id', $id)
            ->update(['display' => '0']);
        // print_r($id);
        // dd($Data);
        return redirect('moviemanager');
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
        if (!($Data->isvalid())) {

            $Errors->add('poster', '檔案無效');

            //確認上傳格式
        } elseif (!(in_array($Type, ['jpeg', 'jpg', 'gif', 'png']))) {

            $Errors->add('poster', '檔案格式錯誤');

            //確認檔案大小
        } elseif ($Size > 1048576) {

            $Errors->add('poster', '檔案大於1MB');
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
