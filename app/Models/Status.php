<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    protected $fillable = [
        'result',
        'time',
        'memory',
        'contest_belong',
        'length',
        'lang',
        'submit_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function problem()
    {
        return $this->belongsTo(Problem::class);
    }



}
