<?php

namespace App\Repository;

use App\Models\apilog;
use App\Models\apiwagers;

class WagersRepository
{

    public function __construct()
    {
        //
    }

    //取apiLog資料
    public function getApiLog($starttime)
    {
        $endtime = clone $starttime;
        $starttime = $starttime->format("Y-m-d H:i:s");
        $endtime = $endtime->format("Y-m-d H:i:59");

        $apiLogList = apilog::select(
            '_index',
            '_type',
            '_id',
            'server_name',
            'request_method',
            'status',
            'size',
            'timestamp'
        )
            ->whereBetween('timestamp', [$starttime, $endtime])
            ->get()->toArray();

        return $apiLogList;
    }

    //確認資料
    public function checkData($apiData)
    {
        $collection = collect($apiData);

        $idArray =  $collection->pluck('_id');

        $apiWagersDB = apiwagers::whereIN('_id', $idArray)
            ->pluck('_id');

        $insertData = $collection->whereNotIn('_id', $apiWagersDB)->toArray();

        return $insertData;
    }

    //寫入apiWagers資料
    public function insertData($insertData)
    {
        $insertArray = [];

        foreach ($insertData as $data) {

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
