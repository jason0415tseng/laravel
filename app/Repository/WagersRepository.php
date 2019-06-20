<?php

namespace App\Repository;

use App\Models\apilog;
use App\Models\apiwagers;
use Illuminate\Support\Facades\Log;

class WagersRepository
{

    public function __construct()
    {
        //
    }

    //取apiLog資料
    public function getApiLogList($starttime, $endtime)
    {
        $apiLogList = apilog::select('*')
            ->whereBetween('timestamp', [$starttime, $endtime])
            ->get();

        $apiLogList = json_decode($apiLogList, true);

        if (!$apiLogList) {
            Log::info(' === 開始時間 ' . $starttime . ' ===');
            Log::error('此時段無任何注單');
            Log::info(' === 結束時間 ' . $endtime . ' ===');

            $msg = (' === 開始時間 ' . $starttime . ' ===') . "\n";
            $msg .= ('此時段無任何注單') . "\n";
            $msg .= (' === 結束時間 ' . $endtime . ' ===') . "\n";

            $apiLogList = [
                'error' => true,
                'msg' => $msg,
            ];
        }
        return $apiLogList;
    }

    //確認資料
    public function checkWagers($apiLogList)
    {
        $collection = collect($apiLogList);

        $idArray =  $collection->pluck('_id');

        $apiWagersDB = apiwagers::whereIN('_id', $idArray)
            ->pluck('_id');

        $insertData = json_decode($collection->whereNotIn('_id', $apiWagersDB), true);

        if (!$insertData) {
            Log::error('目前無任何需新增注單');

            $msg = ('目前無任何需新增注單') . "\n";

            $insertData = [
                'error' => true,
                'msg' => $msg,
            ];
        }
        return $insertData;
    }

    //寫入apiWagers資料
    public function insertWagers($insertData)
    {
        foreach (array_chunk($insertData, 2000, true) as $dataList) {

            $insertArray = [];

            foreach ($dataList as $data) {

                $insertArray[] = [
                    '_index' => $data['_index'],
                    '_type' => $data['_type'],
                    '_id' => $data['_id'],
                    'server_name' => $data['server_name'],
                    'request_method' => $data['request_method'],
                    'status' => $data['status'],
                    'size' => $data['size'],
                    'timestamp' => $data['timestamp'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            }
            apiwagers::insert($insertArray);
        }
    }
}
