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

    //取apiLogTotal資料
    public function getApiLogTotal($starttime)
    {
        $endtime = clone $starttime;
        $starttime = $starttime->format("Y-m-d H:i:s");
        $endtime = $endtime->format("Y-m-d H:i:59");

        $apiLogTotal = apilog::select('*')
            ->whereBetween('timestamp', [$starttime, $endtime])
            ->count('*');

        if (!$apiLogTotal) {
            Log::info(' === 開始時間 ' . $starttime . ' ===');
            Log::error('此時段 ApiLog 無任何注單');
            Log::info(' === 結束時間 ' . $endtime . ' ===');

            $msg = (' === 開始時間 ' . $starttime . ' ===') . "\n";
            $msg .= ('此時段 ApiLog 無任何注單') . "\n";
            $msg .= (' === 結束時間 ' . $endtime . ' ===') . "\n";

            $apiLogTotal = [
                'error' => true,
                'msg' => $msg,
            ];
        }
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

        if (!$apiWagersTotal) {
            Log::info(' === 開始時間 ' . $starttime . ' ===');
            Log::error('此時段 ApiWagers 無任何注單');
            Log::info(' === 結束時間 ' . $endtime . ' ===');

            $msg = (' === 開始時間 ' . $starttime . ' ===') . "\n";
            $msg .= ('此時段 ApiWagers 無任何注單') . "\n";
            $msg .= (' === 結束時間 ' . $endtime . ' ===') . "\n";

            $apiWagersTotal = [
                'error' => true,
                'msg' => $msg,
            ];
        }
        return $apiWagersTotal;
    }

    //確認資料
    public function checkWagers($apiLogTotal, $apiWagersTotal)
    {
        //比對
        if ($apiLogTotal == $apiWagersTotal) {
            Log::info(' ApiLog & ApiWagers 總筆數 ' . $apiLogTotal . ' 筆相同 ');
            $msg = (' ApiLog & ApiWagers 總筆數 ' . $apiLogTotal . ' 筆相同 ') . "\n";

            $checkMsg = [
                'msg' => $msg,
            ];
        }

        if ($apiLogTotal > $apiWagersTotal) {

            Log::info(' ApiLog 總筆數: ' . $apiLogTotal . ' 筆');
            Log::info(' ApiWagers 總筆數: ' . $apiWagersTotal . ' 筆');
            Log::info(' 筆數: ' . ($apiLogTotal - $apiWagersTotal) . ' 筆不相同');

            $msg = ' ApiLog 總筆數: ' . $apiLogTotal . ' 筆' . "\n";
            $msg .= (' ApiWagers 總筆數: ' . $apiWagersTotal . ' 筆') . "\n";
            $msg .= (' 筆數: ' . ($apiLogTotal - $apiWagersTotal) . ' 筆不相同') . "\n";

            $checkMsg = [
                'msg' => $msg,
            ];
        }
        return $checkMsg;
    }
}
