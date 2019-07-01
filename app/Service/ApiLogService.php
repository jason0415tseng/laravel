<?php

namespace App\Service;

use App\Repository\ApiLogRepository;
use Curl;

class ApiLogService
{
    protected $apiLogRepo;

    // 透過 DI 注入 Repository
    public function __construct()
    {
        $this->apiLogRepo = new ApiLogRepository;
    }

    //取得資料
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

        $apiLogData = json_decode($curl->response, true);

        if (($apiLogData['hits']['total']) == 0) {
            print_r('此時段 ApiLog 無任何注單' . "\n");
            return false;
        }
        return $apiLogData;
    }

    //確認資料
    public function checkApiLog($apiLogData)
    {
        $checkData =  $this->apiLogRepo->checkApiLog($apiLogData);
        if (empty($checkData['updateData']) && empty($checkData['insertData'])) {
            $checkData = false;
        }
        return $checkData;
    }

    //新增資料
    public function insertApiLog($insertData)
    {
        if (!empty($insertData)) {
            $this->apiLogRepo->insertApiLog($insertData);
        }
    }

    //更新資料
    public function updateApiLog($updateData)
    {
        if (!empty($updateData)) {
            $this->apiLogRepo->updateApiLog($updateData);
        }
    }
}
