<?php

namespace App\Events;

use App\Models\Contest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ContestMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $contest;
    public function __construct($cid, string $message)
    {
        $this->contest = $cid;
        $this->message = $message;
    }

    //暂时使用公共频道，之后调整为私有
    public function broadcastOn()
    {
        return new Channel('contest.'.$this->contest);
    }
}
