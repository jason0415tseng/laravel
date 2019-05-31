<?php

namespace App\Repository;

use App\Models\register;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth;


class MinGameRepository
{

    protected $register;

    public function __construct(register $register)
    {
        $this->register = $register;
    }

    //創帳號
    public function createAccount($request)
    {

        $auth = new Auth;

        $validator = Validator::make($request, $auth->mingamerules($request), $auth->messages());

        if ($validator->fails()) {

            $error = json_decode($validator->messages(), true);

            return $error;
        }
    }
}
