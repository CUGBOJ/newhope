<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'result',
        'time',
        'memory',
        'contest_belong',
        'length',
        'lang',
        'submit_time',
        'username',
        'pid',
        'be_judged',
        'code',
        'ce_info',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function problem()
    {
        return $this->belongsTo(Problem::class);
    }
}
