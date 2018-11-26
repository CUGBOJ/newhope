<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Team;

class TeamApplyReplied extends Notification implements ShouldQueue
{
    use Queueable;

    public $teamApply;

    public function __construct($team_id, $user_id)
    {
        $this->teamApply = ['team_id' => $team_id, 'user_id' => $user_id, "create_time" => now()];
    }

    public function via($notifiable)
    {
        // 开启通知的频道
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $tmp = $this->teamApply;
        return [
            'user_id' => $tmp['user_id'],
            'team_id' => $tmp['team_id'],
            'create_time' => $tmp['create_time'],
        ];
    }
}