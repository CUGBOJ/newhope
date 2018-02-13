<?php
namespace App\Observers;

use App\Models\Topic;

class TopicObserver
{
    public function deleted(Topic $topic)
    {
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}