<?php
namespace App\Observers;

use App\Models\Announcement;
use App\Models\User;
use App\Notifications\AnnouncementReplied;

class AnnouncementObserver
{
    public function created(Announcement $announcement)
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->messages(new AnnouncementReplied($announcement));
            $user->save();
        }
    }
}
