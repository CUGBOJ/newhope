<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PublicMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct()
    {
        
    }

    // 返回一个公共频道 频道名称为push
    public function broadcastOn()
    {
        return new Channel('push');
    }

    // 自定义事件名，默认使用事件的类名：
    public function broadcastAs()
    {
        return 'PublicMessageEvent';            
    }
    //伴随数据
    public function broadcastWith()
    {
        
        return ['name' => now()->toDateTimeString()];
    }
}
