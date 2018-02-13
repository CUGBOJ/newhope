<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy
{
    public function update(User $user, Reply $reply)
    {
        return $user->isAuthorOf($reply);
    }

    public function destroy(User $user, Reply $reply)
    {
        return $user->isAuthorOf($reply) || $user->isAdmin();
    }
}
