<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
            'username' => 'required|max:30',
            'password' => 'required|max:30',
            'repassword' => 'required|max:30|same:password',
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用户名不能为空',
            'username.max' => '用户名长度不能超过30',
            'password.required' => '密码不能为空',
            'password.max' => '密码长度不能超过30',
            'repassword.required' => '确认密码不能为空',
            'repassword.same' => '两次密码不一致',
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
        ];
    }
}
