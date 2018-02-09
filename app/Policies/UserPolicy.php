<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function is_admin(User $currentUser, User $user)
    {
        return $currentUser->is_admin;
        //return true;
    }
}
