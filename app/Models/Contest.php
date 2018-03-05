<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    //
    protected $fillable = [
        'create_time',
        'start_time',
        'end_time',
        'lock_board_time',
        'owner',
        'password',
        'title',
        'description',
        'isprivate',
        'hide_other'
    ];
    protected $hidden = [
        'password'
    ];
}
