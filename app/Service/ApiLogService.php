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
        $getApiLog = $this->apiLogRepo->getApiLog($request);

        $this->insertData($getApiLog);
    }

    //新增資料
    public function insertData($getApiLog)
    {
        return $this->apiLogRepo->insertData($getApiLog);
    }
}
