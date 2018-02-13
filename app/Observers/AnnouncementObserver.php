<?php
namespace App\Observers;

use App\Notifications\AnnouncementReplied;
use App\Models\Announcement;
use App\Models\User;

class AnnouncementObserver
{
    public function created(Announcement $announcement)
    {
        $user=User::find(1);
        $user->messages(new AnnouncementReplied($announcement));
        $user->save();
        session()->flash('info', $user->username);
        $users=User::all();
        foreach($users as $user){
            $user->increment('notification_count',1);
            $user->save();
        }
    }
}