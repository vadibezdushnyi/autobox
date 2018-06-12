<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageReceived extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $order_id;

    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }

    public function broadcastOn()
    {
        return ['autoboxws'];
    }
}
