<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Problem
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $input
 * @property string|null $output
 * @property string|null $sample_input
 * @property string|null $sample_output
 * @property string|null $hint
 * @property string|null $source
 * @property string $v_name
 * @property string|null $author
 * @property int $hide
 * @property int $special_judge
 * @property int|null $time_limit
 * @property int $case_time_limit
 * @property int|null $memory_limit
 * @property int|null $total_ac
 * @property int|null $total_submit
 * @property int|null $total_ac_user
 * @property int|null $total_submit_user
 * @property int|null $total_wa
 * @property int|null $total_re
 * @property int|null $total_ce
 * @property int|null $total_tle
 * @property int|null $total_mle
 * @property int|null $total_pe
 * @property int|null $total_ole
 * @property int|null $total_rf
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contest[] $contests
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Status[] $statuses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Topic[] $topics
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereCaseTimeLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereHint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereMemoryLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereOutput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereSampleInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereSampleOutput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereSpecialJudge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereTimeLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereTotalAc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereTotalAcUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereTotalCe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereTotalMle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereTotalOle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereTotalPe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereTotalRe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereTotalRf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereTotalSubmit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereTotalSubmitUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereTotalTle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereTotalWa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereVName($value)
 * @mixin \Eloquent
 */
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
        return $this->belongsToMany(Contest::class,'contest_problem',  'problem_id','contest_id')->withPivot('keychar');
    }
}
