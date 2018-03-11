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
            'problem_id' => 'required|exists:problems,id',
            'lang' => 'required|between:1,8',
            'code' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'problem_id.exists'=>'there is no id in problems',
            'problem_id.required'=>'must have problem id',
            'code'=>'must have code file',
        ];
    }
}