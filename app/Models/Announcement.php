<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Announcement
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Announcement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Announcement extends Model
{
    protected $fillable = [
       'title',
       'body',
    ];
}
