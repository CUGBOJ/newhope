<?php

namespace App\Observers;

use App\Models\Status;
use App\Models\User;
use App\Events\PublicMessageEvent;

class StatusObserver
{
    public function created(Status $status)
    {
        $user = $status->user();
        $user->increment('submit', 1);
        if ($status->result === 1) {
            $user->increment('solved', 1);
        }
        
    }
}
