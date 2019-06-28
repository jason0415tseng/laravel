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
            print_r('此時段 ApiLog 無任何注單' . "\n");
            return false;
        }
        return $apiLogTotal;
    }

    //確認資料
    public function getApiWagersTotal($starttime)
    {
        $apiWagersTotal = $this->checkWagersRepo->getApiWagersTotal($starttime);
        if (!$apiWagersTotal) {
            print_r('此時段 ApiWagers 無任何注單' . "\n");
            return false;
        }
        return $apiWagersTotal;
    }

    //確認資料
    public function checkWagers($apiLogTotal, $apiWagersTotal)
    {
        if (!empty($apiLogTotal) && !empty($apiWagersTotal)) {
            return $this->checkWagersRepo->checkWagers($apiLogTotal, $apiWagersTotal);
        }
    }
}
