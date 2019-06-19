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
    public function getApiLogTotal($requestTime)
    {
        return $this->checkWagersRepo->getApiLogTotal($requestTime);
    }

    //確認資料
    public function getApiWagersTotal($requestTime)
    {
        return $this->checkWagersRepo->getApiWagersTotal($requestTime);
    }

    //確認資料
    public function checkWagers($apiLogTotal, $apiWagersTotal)
    {
        $this->checkWagersRepo->checkWagers($apiLogTotal, $apiWagersTotal);
    }
}
