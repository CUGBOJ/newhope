<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $fillable = [
        'title',
        'description',
        'input',
        'output',
        'sample_input',
        'sample_output',
        'hint',
        'source',
        'author',
        'hide',
        'special_judge',
        'time_limit',
        'case_time_limit',
        'memory_limit',
        'total_ac',
        'total_submit',
        'total_ac_user',
        'total_submit_user',

        'created_at',
        'updated_at',
    ];
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
    public function contests()
    {
        return $this->hasMany(Contest::class);
    }
}
