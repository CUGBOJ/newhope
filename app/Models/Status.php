<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    protected $fillable = ['Result','Time','Memory','Length','Lang','Submit_time'];

    public function user()
    {
        return $this->belongsTo(Topic::class);
    }

    public function problem()
    {
        return $this->belongsTo(User::class);
    }



}
