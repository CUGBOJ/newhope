<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
        'username', 'pro_id', 'reply_count','view_count','title','body','last_reply_username','order',
    ];
}
