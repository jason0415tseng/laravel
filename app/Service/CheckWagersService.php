<?php

namespace App\Service;

use App\Repository\CheckWagersRepository;

class CheckWagersService
{
    protected $apiLogRepo;

    // 透過 DI 注入 Repository
    public function __construct()
    {
        $this->checkWagersRepo = new CheckWagersRepository;
    }

    //確認資料
    public function checkWagers($requestTime)
    {
        $this->checkWagersRepo->checkWagers($requestTime);
    }
}
