<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContestRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
//            'title' => 'required|between:3,25',
//            'start_time' => 'required',
//            'end_time' => 'required',
//            'lock_board_time' => 'required',
//            'isprivate' => '1|2',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
