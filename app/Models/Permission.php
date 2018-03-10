<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = false;
    public function roles()
    {
        return $this->belongsToMany('\App\Models\Role','roles_permissions','permission_id','role_id');
    }
}
