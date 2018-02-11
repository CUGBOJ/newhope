<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $currentUser, User $user)
    {
        return $currentUser->username === $user->username;
    }
    public function destroy(User $currentUser, User $user){
        return $currentUser->is_admin &&$currentUser->username!==$user->username;
    }
}
