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
    protected $TimeList;

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
            ->first();

        $Hall = time::select('Hall')
            ->where('Mid', '<>', $id)
            ->get()->toArray();

        $StartTime = strtotime('10:00');

        $EndTime = strtotime('24:00');

        $NewHall = array();

        $Hall = array_column($Hall, 'Hall');

        $Hall = array_diff($this->HallList, $Hall);

        foreach ($Hall as $key => $value) {

            $NewHall[] = $value;
        }

        //列出資料
        if ($Data) {

            $LengthTime = ((($Data['Length']) + 20) * 60);

            for ($i = $StartTime; ($i +  $LengthTime) <= $EndTime; ($i += $LengthTime)) {

                $this->TimeList[] .= date("H:i", ($i));
            };

            return view('backend.timeadd', ['Data' => $Data->makeHidden('attribute')->toArray(), 'Hall' => $NewHall, 'Time' => $this->TimeList]);
        } else {

            $Data = movies::select('Mid', 'Name', 'Length')
                ->where('Mid', $id)
                ->first()->toArray();

            $LengthTime = ((($Data['Length']) + 20) * 60);

            for ($i = $StartTime; ($i +  $LengthTime) <= $EndTime; ($i += $LengthTime)) {

                $this->TimeList[] .= date("H:i", ($i));
            };

            return view('backend.timeadd', ['Data' => $Data, 'Hall' => $Hall, 'Time' => $this->TimeList]);
        }
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

        if (!isset($Data['date'])) {
            $Errors->add('date', '時刻錯誤，請選擇時刻');
            return back()->withErrors($Errors)->withInput();
        }

        //判斷張數
        if (($Data['seat'] < 100) || ($Data['seat'] > 999)) {
            $Errors->add('seat', '數量錯誤，範圍(100~999)');
            return back()->withErrors($Errors)->withInput();
        }

        //確認是否有資料
        $Movie = time::select('*')
            ->where('Mid', $id)
            ->first();

        if ($Movie) {
            //確認廳別
            $Result = time::select('*')
                ->where('Hall', $Data['hall'])
                ->where('Mid', '<>', $id)
                ->first();
        } else {
            //確認廳別
            $Result = time::select('*')
                ->where('Hall', $Data['hall'])
                ->first();
        }

        if ($Result) {
            $Errors->add('hall', '廳別錯誤');
            return back()->withErrors($Errors)->withInput();
        }

        if ($Movie) {
            //轉換
            $Date = $Data['date'];

            $Data['date'] = implode(',', $Date);

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
            $Time->date = $request->date;
            //轉換
            $Date = $Time->date;

            $Time->date = implode(',', $Date);

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
