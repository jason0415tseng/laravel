<?php

namespace App\Repository;

use App\Models\apilog;
use App\Models\apiwagers;
use Illuminate\Support\Facades\Log;

class CheckWagersRepository
{

    protected $checkWagers;

    public function __construct()
    {
        $this->apiwagers = new apiwagers;
    }

    //取資料
    public function checkWagers($requestTime)
    {
        $apiLogTotal = $this->getApiLogTotal($requestTime);

        $apiWagersTotal = $this->getApiWagersTotal($requestTime);

        //比對
        if ($apiLogTotal == $apiWagersTotal) {
            Log::info(' 總筆數 ' . $apiLogTotal . ' 筆相同 ');
            return;
        }

        if ($apiLogTotal > $apiWagersTotal) {

            $this->insertWagers($requestTime);
        }
    }

    //取apiLogTotal資料
    public function getApiLogTotal($requestTime)
    {
        $apiLogTotal = count($this->getApiLogList($requestTime));

        return $apiLogTotal;
    }

    //取apiLog資料
    public function getApiLogList($requestTime)
    {
        $apiLogList = apilog::select('*')
            ->whereBetween('timestamp', [$requestTime['starttime'], $requestTime['endtime']])
            ->get();

        $apiLogList = json_decode($apiLogList, true);

        if (!$apiLogList) {
            Log::info(' === 開始時間 ' . $requestTime['starttime'] . ' ===');
            Log::error('此時段無任何注單');
            Log::info(' === 結束時間 ' . $requestTime['endtime'] . ' ===');
            return;
        }

        return $apiLogList;
    }

    //取apiWagersTotal資料
    public function getApiWagersTotal($requestTime)
    {
        $apiWagersTotal = apiwagers::select('*')
            ->whereBetween('timestamp', [$requestTime['starttime'], $requestTime['endtime']])
            ->count('*');

        return $apiWagersTotal;
    }

    //寫入apiWagers資料
    public function insertWagers($requestTime)
    {
        $apiLogList = $this->getApiLogList($requestTime);

        foreach ($apiLogList as $apilog) {

            $wagers = apiwagers::select('*')
                ->where('_id', $apilog['_id'])
                ->whereBetween('timestamp', [$requestTime['starttime'], $requestTime['endtime']])
                ->first();

            if (is_null($wagers)) {

                $apiwagers = new apiwagers;

                $apiwagers->_index = $apilog['_index'];
                $apiwagers->_type = $apilog['_type'];
                $apiwagers->_id = $apilog['_id'];
                $apiwagers->server_name = $apilog['server_name'];
                $apiwagers->request_method = $apilog['request_method'];
                $apiwagers->status = $apilog['status'];
                $apiwagers->size = $apilog['size'];
                $apiwagers->timestamp = $apilog['timestamp'];

                $apiwagers->save();

                //判斷是否寫入成功
                if (!$apiwagers->save()) {
                    Log::info(' === 寫注單 ' . $apilog['_id'] . ' 失敗 ===');
                }
                Log::info(' === 寫注單 ' . $apilog['_id'] . ' ===');
            } else {
                Log::info(' === 注單 ' . $apilog['_id'] . ' 已存在 ===');
            }
        }
        return;
    }
}
