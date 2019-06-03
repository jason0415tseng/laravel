<?php

namespace App\Repository;

use App\Models\register;
use App\Models\login;
use App\Models\gamegold;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth;


class MinGameRepository
{

    protected $register;
    protected $login;

    public function __construct(register $register, login $login)
    {
        $this->register = $register;
        $this->login = $login;
    }

    //創帳號
    public function createAccount($request)
    {

        $auth = new Auth;

        $validator = Validator::make($request, $auth->mingamerules($request), $auth->messages());

        if ($validator->fails()) {

            $error = json_decode($validator->messages(), true);

            $result = [
                'status' => 2,
                'messages' => $error,
            ];

            return $result;
        }

        //註冊
        $register = new register;

        $register->account = $request['account'];
        $register->password = base64_encode($request['password']);
        $register->name = $request['account'];

        $register->save();

        //註冊遊戲額度
        $uid = register::select('uid')
            ->where('account', $request['account'])
            ->first();

        $gamegold = new gamegold;

        $gamegold->uid = $uid['uid'];
        $gamegold->gold = '1000';

        $gamegold->save();

        $userData = login::select('user.uid', 'user.account', 'gamegold.gold')
            ->join('gamegold', 'gamegold.uid', '=', 'user.uid')
            ->where('account', $request['account'])
            ->where('freeze', '<>', 'N')
            ->first();

        return $userData;
    }

    //登入
    public function login($request)
    {

        $account = $request['account'];
        $password = base64_encode($request['password']);

        $userData = login::select('user.uid', 'user.account', 'gamegold.gold')
            ->join('gamegold', 'gamegold.uid', '=', 'user.uid')
            ->where('account', $account)
            ->where('password', $password)
            ->where('freeze', '<>', 'N')
            ->first();

        if (!$userData) {
            $result = [
                'status' => 2,
                'messages' => '帳號或密碼錯誤',
            ];
            return $result;
        } else {
            return $userData;
        }
    }

    //確認下注金額
    public function checkAmount($request)
    {
        if (!preg_match('/^([1-9][0-9]|100)$/', $request['betAmount'])) {
            $result = [
                'status' => 2,
                'messages' => '下注金額錯誤!!',
            ];
            return $result;
        } else {
            return $request;
        };
    }

    //確認下注號碼
    public function checkNumber($request)
    {
        // dd($request);
        if ((!preg_match('/^([1-9]|10)$/', $request['betNumber'])) && ($request['betNumber'] != 'random')) {
            $result = [
                'status' => 2,
                'messages' => '下注號碼錯誤!!',
            ];
            return $result;
        } else {
            if ($request['betNumber'] == 'random') {
                $request['betNumber'] = rand(0, 9);
                return $request;
            } else {
                return $request;
            }
        };
    }

    //開獎
    public function lottery($request)
    {

        $lottery = rand(0, 9);

        //判斷是否中獎
        if ($lottery != $request['betNumber']) {
            //未中獎
            $result = [
                'status' => true,
                'messages' => '很可惜沒有中獎!!',
                'lottery' => $lottery,
            ];
            return $result;
        } else {
            //中獎
            $result = [
                'status' => true,
                'messages' => '恭喜!! 發大財!!',
                'lottery' => $lottery,
            ];
            return $result;
        };
    }
}
