<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $nickname
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $school
 * @property \Illuminate\Support\Carbon $last_login_time
 * @property \Illuminate\Support\Carbon|null $register_time
 * @property string $last_login_ip
 * @property int $submit
 * @property int $solved
 * @property string|null $remember_token
 * @property int $notification_count
 * @property string|null $avatar
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contest[] $contests
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reply[] $replies
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Status[] $statuses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Topic[] $topics
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastLoginTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNotificationCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRegisterTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSolved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSubmit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;
    const CREATED_AT = 'register_time';
    const UPDATED_AT = 'last_login_time';
    use HasRoles;

    public function messages($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->username == Auth::user()->username) {
            return;
        }
        $this->increment('notification_count', 1);
        $this->notify($instance);
    }

    public function getRouteKeyName()
    {
        return 'username';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $table = 'users';
    protected $fillable = [
        'avatar',
        'nickname',
        'email',
        'password',
        'school',
        'username',
        'last_login_ip',
        'last_login_time',
        'register_time',
        'solved',
        'submit',
        'old_oj_account',
        'student_id',
        'gender',
        'major',
        'info',
        'registered',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'last_login_ip',
        'register_time',
    ];

    public function statuses()
    {
        return $this->hasMany(Status::class, 'username', 'username');
    }

    public function topics()
    {
        return $this->hasMany(Topic::class, 'username', 'username');
    }

    public function contests()
    {
        return $this->belongsToMany('App\Models\Contest', 'contest_user', 'user_id', 'contest_id');
    }

    public function teams()
    {
        return $this->belongsToMany('App\Models\Team', 'team_user', 'user_id', 'team_id');
    }

    public function isAuthorOf($model)
    {
        return $this->username == $model->username;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'username', 'username');
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    /**
     * Get all user permissions in a flat array.
     *
     * @return array
     */
    public function getCanAttribute()
    {
        $permissions = [];
        if (Auth::user()) {
            foreach (Permission::all() as $permission) {
                if (Auth::user()->can($permission->name)) {
                    $permissions[$permission->name] = true;
                } else {
                    $permissions[$permission->name] = false;
                }
            }
        }
        return $permissions;
    }
}
