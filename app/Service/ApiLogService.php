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
    public function getApiLog($request)
    {
        $this->checkApiLog($this->apiLogRepo->getApiLog($request));
    }

    //新增資料
    public function checkApiLog($apiLogData)
    {
        return $this->apiLogRepo->checkApiLog($apiLogData);
    }
}
