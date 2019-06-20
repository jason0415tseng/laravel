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
    public function getApiLogList($starttime, $endtime)
    {

        return $this->WagersRepo->getApiLogList($starttime, $endtime);
    }

    //確認資料
    public function checkWagers($apiLogList)
    {
        return $this->WagersRepo->checkWagers($apiLogList);
    }

    //確認資料
    public function insertWagers($requestTime)
    {
        $this->WagersRepo->insertWagers($requestTime);
    }
}
