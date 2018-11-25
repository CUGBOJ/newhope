<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Topic
 *
 * @property int $id
 * @property string $username
 * @property int $problem_id
 * @property string $title
 * @property string $body
 * @property int $reply_count
 * @property int $view_count
 * @property string $last_reply_username
 * @property int $order
 * @property int|null $contest_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contest|null $contest
 * @property-read \App\Models\Problem $problem
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reply[] $replies
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereContestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereLastReplyUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereProblemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereReplyCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereViewCount($value)
 * @mixin \Eloquent
 */
class Topic extends Model
{
    protected $fillable = [
        'username',
        'problem_id',
        'reply_count',
        'view_count',
        'title',
        'body',
        'last_reply_username',
        'contest_id',
        'order',
    ];

    public function problem()
    {
        return $this->belongsTo(Problem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function contest()
    {
        return $this->belongsTo(Contest::class, 'contest_id', 'id');
    }
}
