<?php

namespace App\Policies;

use App\Models\Contest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContestPolicy
{
    use HandlesAuthorization;

    public function check_permission(User $currentUser, Contest $contest)
    {
        $permissions = $currentUser->role->permissions->toArray();
        $names = array_column($permissions, 'name');
        if (array_search('contest_show', $names, true)) {
            return true;
        }
        if (!$contest->is_private) {
            return true;
        }
        $data = \DB::table('contest_user')->where('contest_id', '=', $contest->id)
            ->where('username', '=', $currentUser->username)->get();
        if (!$data->isEmpty()) {
            return true;
        }
        return false;
    }
}
