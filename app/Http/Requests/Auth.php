<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Auth extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account' => [
                'required',
                'string',
                'regex:/^[a-zA-Z]+[\d]+$|[\d]+[a-zA-Z]+$/',
                'unique:user,account',
                'max:6',
            ],
            'name' => [
                'required',
                'unique:user,name',
                'regex:/^[a-zA-Z]+[\d]+$|[\d]+[a-zA-Z]+$/',
                'max:6',
            ],
            'password' => 'required|string|confirmed|max:8',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function forgotrules()
    {
        return [
            'account' => [
                'required',
                'string',
                'max:6',
            ],
            'password' => 'required|string|confirmed|max:8',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function picrules()
    {
        return [
            'poster' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function mingamerules()
    {
        return [
            'account' => [
                'required',
                'regex:/^[a-zA-Z]+[\d]+$|[\d]+[a-zA-Z]+$/',
                'unique:user,account',
                'max:6',
                'min:6',
            ],
            'password' => 'required|string|confirmed|max:8|min:8',
        ];
    }

    public function messages()
    {
        return [
            'account.required' => '請輸入帳號',
            'account.regex' => '請輸入正確格式',
            'account.unique' => '帳號已存在',
            'account.max' => '帳號請輸入6碼(包含英數)',
            'account.min' => '帳號不足6碼',
            'name.required' => '請輸入名稱',
            'name.unique' => '名稱已存在',
            'name.regex' => '格式錯誤',
            'password.required' => '請輸入密碼',
            'password.confirmed' => '密碼需相同',
            'password.max' => '密碼請輸入8碼(包含英數)',
            'password.min' => '密碼請不足8碼',
            'poster.mimes' => '請上傳JPG、PNG、JPEG、GIF格式的文件',
            'poster.max' => '上傳的圖片大於2M',
        ];
    }
}
