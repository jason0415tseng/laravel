<?php

namespace App\Service;

use App\Repository\ApiLogRepository;
use App\Repository\WagersRepository;

class DataService
{
    protected $apiLogRepository;
    protected $wagersRepository;

    // 透過 DI 注入 Repository
    public function __construct()
    {
        $this->apiLogRepository = new ApiLogRepository;
        $this->wagersRepository = new WagersRepository;
    }

    //取得資料
    public function getApiLog($starttime, $from, $type)
    {
        switch ($type) {
            case 'apilog':
                return $this->apiLogRepository->getApiLog($starttime, $from);
                break;
            case 'apiwagers':
                return $this->wagersRepository->getApiLog($starttime);
                break;
        }
    }

    //確認資料
    public function checkData($apiLogData, $type)
    {
        switch ($type) {
            case 'apilog':
                return $this->apiLogRepository->checkData($apiLogData);
                break;
            case 'apiwagers':
                return $this->wagersRepository->checkData($apiLogData);
                break;
        }
    }

    //新增資料
    public function insertData($insertData, $type)
    {
        switch ($type) {
            case 'apilog':
                return $this->apiLogRepository->insertData($insertData);
                break;
            case 'apiwagers':
                return $this->wagersRepository->insertData($insertData);
                break;
        }
    }

    //更新資料
    public function updateData($updateData, $type)
    {
        switch ($type) {
            case 'apilog':
                return $this->apiLogRepository->updateData($updateData);
                break;
            case 'apiwagers':
                return $this->wagersRepository->updateData($updateData);
                break;
        }
    }
}
