<?php
namespace App\Observers;

use App\Notifications\TopicReplied;
use App\Models\Reply;
use App\Models\User;


class ReplyObserver
{
    public function created(Reply $reply)
    {
        $topic = $reply->topic;
        $topic->increment('reply_count', 1);
        $test=new TopicReplied($reply);

        $topic->user->messages(new TopicReplied($reply));
    }
    public function deleted(Reply $reply)
    {
        $reply->topic->decrement('reply_count', 1);
    }

}