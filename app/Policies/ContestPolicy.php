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
        if($currentUser->isAdmin())
        {
            return true;
        }
        if(!$contest->isprivate)
        {
            return true;
        }
        $data=\DB::table('contest_user')->where('contest_id', '=', $contest->id)->where('user_id', '=', $currentUser->id)->get();
        if (!$data->isEmpty()) {
            return true;
        }
        return false;
    }
    public function is_admin(User $currentUser)
    {
        return $currentUser->isAdmin();
        //return true;
    }
}
