<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nickname' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/',
            'email' => 'email',
            'password' => 'nullable|confirmed|min:6',
            'school' => 'max:20',
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200',
        ];
    }
    public function messages()
    {
        return [
            'avatar.mimes' =>'头像必须是 jpeg, bmp, png, gif 格式的图片',
            'avatar.dimensions' => '图片的清晰度不够，宽和高需要 200px 以上',
            'nickname.regex' => '用户名只支持中英文、数字、横杆和下划线。',
            'nickname.between' => '用户名必须介于 3 - 25 个字符之间。',
            'password.confirmed' =>'密码与确认密码必须一致',
            'password.min' =>'密码至少6位',
        ];
    }
}