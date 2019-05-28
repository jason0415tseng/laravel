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
    public function showMovieList()
    {
        //列出資料
        $movieData = movies::select('*')
            ->where('display', '1')
            ->orderBy('ondate', 'ASC')
            ->get()->toArray();

        return view('backend.timemanager', ['movieData' => $movieData]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAddPage($id)
    {
        //列出資料
        $movieData = movies::select('movies.Mid', 'movies.Name', 'movies.Length', 'time.Hall', 'time.Time', 'time.Seat')
            ->join('time', 'movies.mid', '=', 'time.mid')
            ->where('movies.Mid', $id)
            ->first();

        $movieHall = time::select('Hall')
            ->where('Mid', '<>', $id)
            ->get()->toArray();

        $startTime = strtotime('10:00');

        $endTime = strtotime('24:00');

        $newHall = array();

        $hall = array_column($movieHall, 'Hall');

        $hall = array_diff($this->HallList, $hall);

        foreach ($hall as $key => $value) {

            $newHall[] = $value;
        }

        //列出資料
        if ($movieData) {

            $lengthTime = ((($movieData['Length']) + 20) * 60);

            for ($i = $startTime; ($i +  $lengthTime) <= $endTime; ($i += $lengthTime)) {

                $this->TimeList[] .= date("H:i", ($i));
            };

            return view('backend.timeadd', ['movieData' => $movieData->toArray(), 'hall' => $newHall, 'time' => $this->TimeList]);
        } else {

            $movieData = movies::select('Mid', 'Name', 'Length')
                ->where('Mid', $id)
                ->first();

            if (!$movieData) {
                return redirect('timemanager');
            } else {
                $lengthTime = ((($movieData['Length']) + 20) * 60);

                for ($i = $startTime; ($i +  $lengthTime) <= $endTime; ($i += $lengthTime)) {

                    $this->TimeList[] .= date("H:i", ($i));
                };

                return view('backend.timeadd', ['movieData' => $movieData->toArray(), 'hall' => $hall, 'time' => $this->TimeList]);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateTime(Request $request, $id)
    {
        $errors = new MessageBag;

        //資料
        $requestData = $request->all();

        if (!isset($requestData['time'])) {
            $errors->add('time', '時刻錯誤，請選擇時刻');
            return back()->withErrors($errors)->withInput();
        }

        //判斷張數
        if (($requestData['seat'] < 100) || ($requestData['seat'] > 999)) {
            $errors->add('seat', '數量錯誤，範圍(100~999)');
            return back()->withErrors($errors)->withInput();
        }

        //確認是否有資料
        $movieData = time::select('*')
            ->where('Mid', $id)
            ->first();

        if ($movieData) {
            //確認廳別
            $Result = time::select('*')
                ->where('Hall', $requestData['hall'])
                ->where('Mid', '<>', $id)
                ->first();
        } else {
            //確認廳別
            $Result = time::select('*')
                ->where('Hall', $requestData['hall'])
                ->first();
        }

        if ($Result) {
            $errors->add('hall', '廳別錯誤');
            return back()->withErrors($errors)->withInput();
        }

        if ($movieData) {
            //更新
            foreach ($requestData['time'] as $date) {
                $Result = time::where('Mid', $id)
                    ->where('time', $date)
                    ->update([
                        'hall' => $requestData['hall'],
                        'time' => $date,
                        'seat' => $requestData['seat'],
                    ]);
            }
        } else {
            foreach ($request->time as $Date) {
                //新增
                $Time = new time;
                $Time->mid = $id;
                $Time->hall = $request->hall;
                $Time->time = $Date;
                $Time->seat = $request->seat;
                $Time->save();
            }
        }

        return redirect('/timemanager');
    }
}
