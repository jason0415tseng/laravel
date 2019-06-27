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
    public function getApiLogTotal($starttime)
    {
        $apiLogTotal = $this->checkWagersRepo->getApiLogTotal($starttime);
        if (!$apiLogTotal) {
            return false;
        }
        return $apiLogTotal;
    }

    //確認資料
    public function getApiWagersTotal($starttime)
    {
        $apiWagersTotal = $this->checkWagersRepo->getApiWagersTotal($starttime);
        if (!$apiWagersTotal) {
            return false;
        }
        return $apiWagersTotal;
    }

    //確認資料
    public function checkWagers($apiLogTotal, $apiWagersTotal)
    {
        return $this->checkWagersRepo->checkWagers($apiLogTotal, $apiWagersTotal);
    }
}
