<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Reply;

class TopicReplied extends Notification implements ShouldQueue
{
    use Queueable;

    public $reply;

    public function __construct(Reply $reply)
    {
        // 注入回复实体，方便 toDatabase 方法中的使用
        $this->reply = $reply;
    }

    public function via()
    {
        // 开启通知的频道
        return ['database'];
    }

    public function toDatabase()
    {
        $topic = $this->reply->topic;
        // 存入数据库里的数据
        return [
            'reply_id' => $this->reply->id,
            'reply_content' => $this->reply->content,
            'username' => $this->reply->username,
            'topic_id' => $topic->id,
            'topic_title' => $topic->title,
        ];
    }
}