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
        //$user=$topic->user;
        $s = var_export(Array($topic->user),true);
        //session()->flash('info',$s);
        $topic->user->messages(new TopicReplied($reply));
    }

}