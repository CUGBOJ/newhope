<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contest
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $lock_board_time
 * @property string $owner
 * @property string|null $password
 * @property string $title
 * @property string|null $description
 * @property int $isprivate
 * @property int $hide_other
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Problem[] $problems
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $reject_users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Status[] $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Topic[] $topics
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contest whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contest whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contest whereHideOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contest whereIsprivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contest whereLockBoardTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contest whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contest wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contest whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contest whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contest extends Model
{
    protected $fillable = [
        'create_time',
        'start_time',
        'end_time',
        'lock_board_time',
        'owner',
        'password',
        'title',
        'description',
        'private',
        'hide_other',
    ];
    protected $hidden = [
        'password',
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'contest_user', 'contest_id', 'user_id');
    }

    public function reject_users()
    {
        return $this->belongsToMany(User::class, 'contest_reject_user', 'contest_id', 'user_id');
    }

    public function problems()
    {
        return $this->belongsToMany(Problem::class,'contest_problem', 'contest_id', 'problem_id')->withPivot('keychar')->orderBy('contest_problem.keychar', 'asc');
    }
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
    public function status()
    {
        return $this->hasMany(Status::class);
    }
}
