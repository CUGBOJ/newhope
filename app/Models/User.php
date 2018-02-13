<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;
    public function messages($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->username == Auth::user()->username) {
            return;
        }
        $this->increment('notification_count');
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
        'nickname', 'email', 'password','school','username','last_login_ip','last_login_time','solved','submit'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','last_login_ip','last_login_time',
    ];
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
    public function isAuthorOf($model)
    {
        return $this->username == $model->username;
    }
    public  function isAdmin(){
        return $this->is_admin;
    }
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

}
