<?php

namespace App\Service;

use App\Repository\ApiLogRepository;

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
        $apiLogData = $this->apiLogRepo->getApiLog($starttime, $from);
        if (($apiLogData['hits']['total']) == 0) {
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
        return $this->apiLogRepo->insertApiLog($insertData);
    }

    //更新資料
    public function updateApiLog($updateData)
    {
        return $this->apiLogRepo->updateApiLog($updateData);
    }
}
