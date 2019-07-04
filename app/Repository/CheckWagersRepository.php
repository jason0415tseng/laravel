<?php

namespace App\Repository;

use App\Models\apilog;
use App\Models\apiwagers;

class CheckWagersRepository
{

    public function __construct()
    {
        //
    }

    //取apiLogTotal資料
    public function getApiLogTotal($starttime)
    {
        $endtime = clone $starttime;
        $starttime = $starttime->format("Y-m-d H:i:s");
        $endtime = $endtime->format("Y-m-d H:i:59");

        $apiLogTotal = apilog::select('*')
            ->whereBetween('timestamp', [$starttime, $endtime])
            ->count('*');

        return $apiLogTotal;
    }

    //取apiWagersTotal資料
    public function getApiWagersTotal($starttime)
    {
        $endtime = clone $starttime;
        $starttime = $starttime->format("Y-m-d H:i:00");
        $endtime = $endtime->format("Y-m-d H:i:59");

        $apiWagersTotal = apiwagers::select('*')
            ->whereBetween('timestamp', [$starttime, $endtime])
            ->count('*');

        return $apiWagersTotal;
    }
}
