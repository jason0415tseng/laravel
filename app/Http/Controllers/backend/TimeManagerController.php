<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\movies;
use App\Models\time;

class TimeManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //列出資料
        $Data = movies::select('*')
            // ->join('time', 'movies.mid', '=', 'time.mid')
            ->where('display', '1')
            ->orderBy('ondate', 'ASC')
            ->get();

        return view('backend.timemanager', ['Data' => $Data->makeHidden('attribute')->toArray()]);
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
    public function getmovietime($id)
    {
        //列出資料
        $Data = movies::select('Mid', 'name')
            ->where('Mid', $id)
            // ->where('account', '<>', $Account)
            ->get();

        return view('backend.timeedit', ['Data' => $Data->makeHidden('attribute')->toArray()]);
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
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add($id)
    {
        //列出資料
        $Data = movies::select('movies.Mid', 'movies.Name', 'time.Hall', 'time.Date', 'time.Seat')
            ->join('time', 'movies.mid', '=', 'time.mid')
            ->where('movies.Mid', $id)
            // ->where('account', '<>', $Account)
            ->get();
        //列出資料
        // $Data = movies::select('*')
        //     ->join('time', 'movies.mid', '=', 'time.mid')
        //     ->where('movies.Mid', $id)
        //     // ->where('account', '<>', $Account)
        //     ->get();
        if ($Data->toArray()) {
            // echo "ASD";
            // exit;
            return view('backend.timeadd', ['Data' => $Data->makeHidden('attribute')->toArray()]);
        } else {
            $Data = movies::select('Mid', 'Name')
                ->where('Mid', $id)
                ->get();
            return view('backend.timeadd', ['Data' => $Data->makeHidden('attribute')->toArray()]);
        }
        // return view('backend.movieedit', ['Data' => $Data->makeHidden('attribute')->toArray()]);
        // /
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function timeadd(Request $request, $id)
    {
        //
        // $Data = $request->all();
        // print_r($Data);
        // print_r("\n");
        // print_r($id);
        // exit;



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
        $Time = new time;

        $Time->mid = $id;
        // print_r($Time->mid);
        // exit;
        $Time->hall = $request->hall;
        $Time->date = [
            $request->date_1,
            $request->date_2,
            $request->date_3,
            $request->date_4,
            $request->date_5,
            $request->date_6,
        ];

        //轉換
        $date = $Time->date;
        // print_r($date);
        $Time->date = implode(',', $date);
        // print_r($Time->date);
        // exit;
        // dd($Time->date);
        // exit;
        $Time->seat = $request->seat;


        $Time->save();

        return redirect('/timemanager');
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
