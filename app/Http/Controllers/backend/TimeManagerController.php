<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\movies;
use App\Models\time;
use Illuminate\Support\MessageBag;

class TimeManagerController extends Controller
{
    protected $HallList;

    /**
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        $this->HallList = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
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
        $Data = movies::select('movies.Mid', 'movies.Name', 'movies.Length', 'time.Hall', 'time.Date', 'time.Seat')
            ->join('time', 'movies.mid', '=', 'time.mid')
            ->where('movies.Mid', $id)
            // ->orwhere('time.Mid', '<>', $id)
            ->get();

        $Hall = time::select('Hall')
            ->where('Mid', '<>', $id)
            ->get()->toArray();

        $NewHall = array();

        $Hall = array_column($Hall, 'Hall');

        $Hall = array_diff($this->HallList, $Hall);

        // print_r($Hall);
        // print($hall);

        foreach ($Hall as $key => $value) {

            $NewHall[] = $value;
        }

        //列出資料
        if ($Data->toArray()) {

            return view('backend.timeadd', ['Data' => $Data->makeHidden('attribute')->toArray(), 'Hall' => $NewHall]);
        } else {

            $Data = movies::select('Mid', 'Name')
                ->where('Mid', $id)
                ->get()->toArray();

            return view('backend.timeadd', ['Data' => $Data, 'Hall' => $Hall]);
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
        $Errors = new MessageBag;

        //資料
        $Data = $request->all();

        //確認廳別
        $Result = time::select('*')
            ->where('Hall', $Data['hall'])
            ->first();

        if ($Result) {

            $Errors->add('hall', '廳別錯誤');
            return back()->withErrors($Errors)->withInput();
        }

        //確認是否有資料
        $Movie = time::select('*')
            ->where('Mid', $id)
            ->first();

        if ($Movie) {

            //更新
            $Result = time::where('Mid', $id)
                ->update([
                    'hall' => $Data['hall'],
                    'date' => $Data['date'],
                    'seat' => $Data['seat'],
                ]);
        } else {

            //新增
            $Time = new time;

            $Time->mid = $id;
            $Time->hall = $request->hall;
            // $Time->date = [
            //     $request->date_1,
            //     $request->date_2,
            //     $request->date_3,
            //     $request->date_4,
            //     $request->date_5,
            //     $request->date_6,
            // ];
            $Time->date = $request->date;
            //轉換
            $Date = $Time->date;

            // $Time->date = implode(',', $Date);

            $Time->seat = $request->seat;

            $Time->save();
        }

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
