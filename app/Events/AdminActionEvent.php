<?php
/**
 * 后台管理员操作事件写入日志
 */
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AdminActionEvent
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     * @content 日志内容
     * @return void
     */
    public function __construct(string $content)
    {
        $this->uid = auth('admin')->user()->id;
        $this->adminName = auth('admin')->user()->name;
        $this->content = $content;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
