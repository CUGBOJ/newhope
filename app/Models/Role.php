<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', 'roles_permissions', 'role_id', 'permission_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
