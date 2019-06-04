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

    //登入
    public function login($request)
    {
        return $this->minGameRepo->login($request);
    }

    //確認下注金額
    public function getUserData($request)
    {
        return $this->minGameRepo->getUserData($request);
    }

    //確認下注金額
    public function checkAmount($request)
    {
        return $this->minGameRepo->checkAmount($request);
    }

    //確認下注號碼
    public function checkNumber($request)
    {
        return $this->minGameRepo->checkNumber($request);
    }

    //開獎
    public function lottery($request)
    {
        return $this->minGameRepo->lottery($request);
    }
}
