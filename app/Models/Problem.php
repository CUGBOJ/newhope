<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'input',
        'output',
        'sample_input',
        'sample_output',
        'author',
        'hide',
        'hint',
        'ac_number',
        'submit_number',
        'ac_user_number',
        'submit_user_number',
        'time_limit',
        'memory_limit',
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
}