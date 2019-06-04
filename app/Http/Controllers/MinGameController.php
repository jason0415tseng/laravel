<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\MinGameService;

class MinGameController extends Controller
{
    protected $minGameService;

    public function __construct(MinGameService $minGameService)
    {
        $this->minGameService = $minGameService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function createAccount($request)
    {
        return $this->minGameService->createAccount($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function login($request)
    {
        return $this->minGameService->login($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function checkAmount($request)
    {
        return $this->minGameService->checkAmount($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function checkNumber($request)
    {
        return $this->minGameService->checkNumber($request);
    }


    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function lottery($request)
    {
        return $this->minGameService->lottery($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUserData($request)
    {
        return $this->minGameService->getUserData($request);
    }
}
