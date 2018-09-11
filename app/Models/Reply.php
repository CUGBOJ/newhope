<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Reply
 *
 * @property mixed id
 * @property string content
 * @property string username
 * @property mixed topic
 * @property int $id
 * @property int $topic_id
 * @property string $username
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Topic $topic
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereTopicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply whereUsername($value)
 * @mixin \Eloquent
 */
class Reply extends Model
{
    protected $fillable = [
        'content',
        'username',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }
}
