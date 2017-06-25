<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DriverResultReturned implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order_id, $status, $driver_id, $driver_name, $driver_image;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order_id, $status, $driver_id = null, $driver_name = null, $driver_image = null)
    {
        //
        $this->order_id = $order_id;
        $this->status = $status;
        $this->driver_id = $driver_id;
        $this->driver_name = $driver_name;
        $this->driver_image = $driver_image;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['order-id-' . $this->order_id];
    }
}
