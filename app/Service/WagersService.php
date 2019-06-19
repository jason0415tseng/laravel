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
    public function getApiLogList($requestTime)
    {

        return $this->WagersRepo->getApiLogList($requestTime);
    }

    //確認資料
    public function checkWagers($requestTime)
    {
        return $this->WagersRepo->checkWagers($requestTime);
    }

    //確認資料
    public function insertWagers($requestTime)
    {
        $this->WagersRepo->insertWagers($requestTime);
    }
}
