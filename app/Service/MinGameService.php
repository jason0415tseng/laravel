<?php

namespace App\Service;

use App\Repository\MinGameRepository;

class MinGameService
{
    protected $minGameRepo;

    // 透過 DI 注入 Repository
    public function __construct(MinGameRepository $minGameRepo)
    {
        $this->minGameRepo = $minGameRepo;
    }

    //註冊
    public function createAccount($request)
    {
        return $this->minGameRepo->createAccount($request);
    }
}
