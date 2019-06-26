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
        return $this->WagersRepo->getApiLogList($starttime);
    }

    //確認資料
    public function checkWagers($apiData)
    {
        return $this->WagersRepo->checkWagers($apiData);
    }

    //確認資料
    public function insertWagers($insertData)
    {
        $this->WagersRepo->insertWagers($insertData);
    }
}
