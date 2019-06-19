<?php

namespace App\Repository;

use App\Models\apilog;
use App\Models\apiwagers;
use Illuminate\Support\Facades\Log;

class CheckWagersRepository
{

    public function __construct()
    {
        //
    }

    //確認資料
    public function checkWagers($apiLogTotal, $apiWagersTotal)
    {
        //比對
        if ($apiLogTotal == $apiWagersTotal) {
            Log::info(' 總筆數 ' . $apiLogTotal . ' 筆相同 ');
            $msg = (' 總筆數 ' . $apiLogTotal . ' 筆相同 ') . "\n";
            print_r($msg);

            return;
        }

        if ($apiLogTotal > $apiWagersTotal) {

            Log::info(' ApiLog 總筆數: ' . $apiLogTotal . ' 筆');
            Log::info(' Wagers 總筆數: ' . $apiWagersTotal . ' 筆');
            Log::info(' 筆數: ' . ($apiLogTotal - $apiWagersTotal) . ' 筆不相同');

            $msg = ' ApiLog 總筆數: ' . $apiLogTotal . ' 筆' . "\n";
            $msg .= (' Wagers 總筆數: ' . $apiWagersTotal . ' 筆') . "\n";
            $msg .= (' 筆數: ' . ($apiLogTotal - $apiWagersTotal) . ' 筆不相同') . "\n";

            print_r($msg);

            return;
        }
    }

    //取apiLogTotal資料
    public function getApiLogTotal($requestTime)
    {
        $apiLogTotal = apilog::select('*')
            ->whereBetween('timestamp', [$requestTime['starttime'], $requestTime['endtime']])
            ->count('*');

        $apiLogTotal = json_decode($apiLogTotal, true);

        if (!$apiLogTotal) {
            Log::info(' === 開始時間 ' . $requestTime['starttime'] . ' ===');
            Log::error('此時段無任何注單');
            Log::info(' === 結束時間 ' . $requestTime['endtime'] . ' ===');
            return;
        }

        return $apiLogTotal;
    }

    //取apiWagersTotal資料
    public function getApiWagersTotal($requestTime)
    {
        $apiWagersTotal = apiwagers::select('*')
            ->whereBetween('timestamp', [$requestTime['starttime'], $requestTime['endtime']])
            ->count('*');

        return $apiWagersTotal;
    }
}
