<?php

namespace App\Repository;

use App\Models\apilog;
use Curl;

class ApiLogRepository
{

    protected $apilog;

    public function __construct()
    {
        $this->apilog = new apilog;
    }

    //取資料
    public function getApiLog($params)
    {
        $params = urldecode(http_build_query($params));

        $url = 'http://train.rd6/?' . $params;

        $curl = new Curl\Curl();

        $curl->get($url);

        $response = json_decode($curl->response, true);

        return $response;
    }

    //確認資料
    public function checkApiLog($apiLogData)
    {
        $collection = collect($apiLogData['hits']['hits']);

        $idArray =  $collection->pluck('_id');

        $apiLogDB = apilog::whereIN('_id', $idArray)
            ->pluck('_id');

        $updateData = json_decode($collection->whereIn('_id', $apiLogDB), true);

        $insertData = json_decode($collection->whereNotIn('_id', $apiLogDB), true);

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
        foreach (array_chunk($insertData, 2000, true) as $dataList) {

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
                ];
            }
            apilog::insert($insertArray);
        }
    }
}
