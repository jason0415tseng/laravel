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
    public function insertData($getApiLog)
    {
        foreach ($getApiLog['hits']['hits'] as $data) {

            $time = explode('+', $data['_source']['@timestamp']);

            $apiLogData = apilog::select('*')
                ->where('_id', $data['_id'])
                ->first();

            if ($apiLogData) {
                apilog::where('_id', $data['_id'])
                    ->update([
                        '_index' => $data['_index'],
                        '_type' => $data['_type'],
                        '_id' => $data['_id'],
                        'server_name' => $data['_source']['server_name'],
                        'request_method' => $data['_source']['request_method'],
                        'status' => $data['_source']['status'],
                        'size' => $data['_source']['size'],
                        'timestamp' => $time[0],
                    ]);
            } else {

                $apilog = new apilog;

                $apilog->_index = $data['_index'];
                $apilog->_type = $data['_type'];
                $apilog->_id = $data['_id'];
                $apilog->server_name = $data['_source']['server_name'];
                $apilog->request_method = $data['_source']['request_method'];
                $apilog->status = $data['_source']['status'];
                $apilog->size = $data['_source']['size'];
                $apilog->timestamp = $time[0];

                $apilog->save();
            }
        }
    }
}
