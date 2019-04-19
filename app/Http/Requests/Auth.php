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
                // 'string',
                // 'regex:^(?=.*\d)(?=.*[a-zA-Z])(?!.*\s).*$',


                'regex:/^[a-zA-Z]+[0-9]+$|[0-9]+[a-zA-Z]+$/',

                // 'regex:(^(?=.*\d)(?=.*[a-zA-Z])(?!.*\s).*$)',

                // 'regex:/^((\d+)$)[0-9a-zA-Z]+)/u',
                'max:6' ,
            ],
            'password' => 'required|string|confirmed|max:8',
        ];
    }

    public function messages()
    {
        return [
            'account.required' => '請輸入帳號' ,
            'account.regex' => '請輸入正確格式' ,
            // 'account.^(?=.*\d)(?=.*[a-zA-Z])(?!.*\s).*$' => '請輸入正確格式' ,
            'password.required' => '請輸入密碼' ,
            'password.confirmed' => '密碼需相同',
        ];
    }
}
