<?php
namespace App\Observers;

use App\Models\Reply;
use App\Models\User;
use App\Notifications\TopicReplied;

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $topic = $reply->topic;
        $test = new TopicReplied($reply);
        $topic->user->messages(new TopicReplied($reply));
    }
    public function deleted(Reply $reply)
    {
        $reply->topic->decrement('reply_count', 1);
    }

}
