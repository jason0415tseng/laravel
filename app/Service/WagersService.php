<?php

namespace App\Service;

use App\Repository\WagersRepository;

class WagersService
{
    protected $insertWagersRepo;

    // 透過 DI 注入 Repository
    public function __construct()
    {
        $this->WagersRepo = new WagersRepository;
    }

    //確認資料
    public function getApiLogList($starttime)
    {
        $apiLogList = $this->WagersRepo->getApiLogList($starttime);
        if (!$apiLogList) {
            print_r('此時段 ApiLog 無任何注單' . "\n");
            return false;
        }
        return $apiLogList;
    }

    //確認資料
    public function checkWagers($apiData)
    {
        $insertData = $this->WagersRepo->checkWagers($apiData);
        if (!$insertData) {
            return false;
        }
        return $insertData;
    }

    //確認資料
    public function insertWagers($insertData)
    {
        if (!empty($insertData)) {
            $this->WagersRepo->insertWagers($insertData);
        }
    }
}
