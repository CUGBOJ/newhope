<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class JudgeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pid' => 'required|exists:problems,id',
            'lang' => 'required|between:1,8',
            'code' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'pid.exists'=>'there is no id in problems',
            'pid.required'=>'must have problem id',
            'code'=>'must have code file',
        ];
    }
}