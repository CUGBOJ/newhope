<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Reply extends Model
{
    protected $fillable = ['content','username'];
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
