<?php

namespace App\Repository;

use App\Models\apilog;

class ApiLogRepository
{

    protected $apilog;

    public function __construct()
    {
        $this->apilog = new apilog;
    }

    //確認資料
    public function checkApiLog($apiLogData)
    {
        $collection = collect($apiLogData['hits']['hits']);

        $idArray =  $collection->pluck('_id');

        $apiLogDB = apilog::whereIN('_id', $idArray)
            ->pluck('_id');

        $updateData = $collection->whereIn('_id', $apiLogDB)->toArray();

        $insertData = $collection->whereNotIn('_id', $apiLogDB)->toArray();

        $checkData = [
            'insertData' => $insertData,
            'updateData' => $updateData,
        ];
        return $checkData;
    }

    //更新資料
    public function updateApiLog($updateData)
    {
        foreach ($updateData as $data) {

            $time = explode('+', $data['_source']['@timestamp']);

            apilog::where('_id', $data['_id'])
                ->update([
                    '_index' => $data['_index'],
                    '_type' => $data['_type'],
                    'server_name' => $data['_source']['server_name'],
                    'request_method' => $data['_source']['request_method'],
                    'status' => $data['_source']['status'],
                    'size' => $data['_source']['size'],
                    'timestamp' => $time[0],
                ]);
        }
    }

    //新增資料
    public function insertApiLog($insertData)
    {
        foreach (array_chunk($insertData, 500, true) as $dataList) {

            $insertArray = [];

            foreach ($dataList as $data) {

                $time = explode('+', $data['_source']['@timestamp']);

                $insertArray[] = [
                    '_index' => $data['_index'],
                    '_type' => $data['_type'],
                    '_id' => $data['_id'],
                    'server_name' => $data['_source']['server_name'],
                    'request_method' => $data['_source']['request_method'],
                    'status' => $data['_source']['status'],
                    'size' => $data['_source']['size'],
                    'timestamp' => $time[0],
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            }
            apilog::insert($insertArray);
        }
    }
}
