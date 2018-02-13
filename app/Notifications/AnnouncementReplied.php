<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Announcement;

class AnnouncementReplied extends Notification
{
    use Queueable;

    public $announcement;

    public function __construct(Announcement $announcement)
    {
        // 注入回复实体，方便 toDatabase 方法中的使用
        $this->announcement = $announcement;
    }

    public function via($notifiable)
    {
        // 开启通知的频道
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $announcement=$this->announcement;
        // 存入数据库里的数据
        return [
            'announcement_id' => $announcement->id,
            'announcement_title' => $announcement->title,
            'body' => $announcement->body,
        ];
    }
}