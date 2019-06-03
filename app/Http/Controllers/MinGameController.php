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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show($account)
    {
        return print('你的帳號:' . $account);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
