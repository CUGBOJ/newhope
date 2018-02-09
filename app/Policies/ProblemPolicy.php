<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class ProblemPolicy
{
    use HandlesAuthorization;

    public function update(User $currentUser)
    {
        //return $currentUser->is_admin;
        return true;
    }

    public function create(User $currentUser)
    {
        //return $currentUser->is_admin;
        return true;
    }

}
