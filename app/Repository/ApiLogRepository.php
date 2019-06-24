<?php

namespace App\Repository;

use App\Models\apilog;
use Log;
use Curl;

class ApiLogRepository
{

    protected $apilog;

    public function __construct()
    {
        $this->apilog = new apilog;
    }

    //取資料
    public function getApiLog($starttime, $from)
    {
        $endtime = clone $starttime;
        $starttime = $starttime->format("Y-m-d\TH:i:s");
        $endtime = $endtime->format("Y-m-d\TH:i:59");

        $params = [
            'start' => $starttime,
            'end' => $endtime,
            'from' => $from
        ];

        $urlData = urldecode(http_build_query($params));

        $url = 'http://train.rd6/?' . $urlData;

        $curl = new Curl\Curl();

        $curl->get($url);

        $response = json_decode($curl->response, true);

        if (($response['hits']['total']) == 0) {
            Log::info(' === 開始時間 ' . $params['start'] . ' ===');
            Log::error('此時段 ApiLog 無任何注單');
            Log::info(' === 結束時間 ' . $params['end'] . ' ===');

            $msg = (' === 開始時間 ' . $params['start'] . ' ===') . "\n";
            $msg .= ('此時段 ApiLog 無任何注單') . "\n";
            $msg .= (' === 結束時間 ' . $params['end'] . ' ===') . "\n";

            $response = [
                'error' => true,
                'msg' => $msg,
            ];
        }
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

        if (count($updateData) == 0 && count($insertData) == 0) {
            Log::error('目前無任何需更新或新增注單');

            $msg = ('目前無任何需更新或新增注單') . "\n";

            $checkData = [
                'error' => true,
                'msg' => $msg,
            ];
        } else {
            $checkData = [
                'insertData' => $insertData,
                'updateData' => $updateData,
            ];
        }
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
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            }
            apilog::insert($insertArray);
        }
    }
}
