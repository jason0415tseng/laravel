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

    //新增資料
    public function insertData($ApiLogData)
    {
        foreach ($ApiLogData['hits']['hits'] as $data) {

            $time = explode('+', $data['_source']['@timestamp']);

            apilog::updateOrCreate(
                ['_id' => $data['_id']],
                [
                    '_index' => $data['_index'],
                    '_type' => $data['_type'],
                    '_id' => $data['_id'],
                    'server_name' => $data['_source']['server_name'],
                    'request_method' => $data['_source']['request_method'],
                    'status' => $data['_source']['status'],
                    'size' => $data['_source']['size'],
                    'timestamp' => $time[0],
                ],
            );
        }
    }
}
