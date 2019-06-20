<?php

namespace App\Service;

use App\Repository\CheckWagersRepository;

class CheckWagersService
{
    protected $checkWagersRepo;

    // 透過 DI 注入 Repository
    public function __construct()
    {
        $this->checkWagersRepo = new CheckWagersRepository;
    }

    //確認資料
    public function getApiLogTotal($starttime, $endtime)
    {
        return $this->checkWagersRepo->getApiLogTotal($starttime, $endtime);
    }

    //確認資料
    public function getApiWagersTotal($starttime, $endtime)
    {
        return $this->checkWagersRepo->getApiWagersTotal($starttime, $endtime);
    }

    //確認資料
    public function checkWagers($apiLogTotal, $apiWagersTotal)
    {
        return $this->checkWagersRepo->checkWagers($apiLogTotal, $apiWagersTotal);
    }
}
