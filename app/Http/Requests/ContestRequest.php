<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $lock_board_time
 * @property string|null $password
 * @property string $title
 * @property string|null $description
 * @property int $is_private
 * @property int $hide_other
 * @property mixed problems
 * @property int register_required
 */
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
//            'is_private' => '1|2',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
