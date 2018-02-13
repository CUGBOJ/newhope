<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class AnnouncementPolicy
{
    use HandlesAuthorization;
    public function is_admin(User $currentUser)
    {
        return $currentUser->isAdmin();
        //return true;
    }
}
