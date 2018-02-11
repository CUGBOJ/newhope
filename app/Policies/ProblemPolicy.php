<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class ProblemPolicy
{
    use HandlesAuthorization;
    public function is_admin(User $currentUser)
    {
        return $currentUser->is_admin;
        //return true;
    }


}
