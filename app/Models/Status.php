<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Status
 *
 * @property int $id
 * @property string $username
 * @property int $pid
 * @property int|null $contest_id
 * @property string $result
 * @property int|null $time
 * @property int|null $memory
 * @property int $length
 * @property int $lang
 * @property string $submit_time
 * @property string $code
 * @property int $be_judged
 * @property string|null $ce_info
 * @property-read \App\Models\Contest|null $contest
 * @property-read \App\Models\Problem $problem
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Status whereBeJudged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Status whereCeInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Status whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Status whereContestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Status whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Status whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Status whereMemory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Status wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Status whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Status whereSubmitTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Status whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Status whereUsername($value)
 * @mixin \Eloquent
 */
class Status extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'result',
        'time',
        'memory',
        'contest_id',
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

    public function contest()
    {
        return $this->belongsTo(Contest::class, 'contest_id', 'id');
    }
}
