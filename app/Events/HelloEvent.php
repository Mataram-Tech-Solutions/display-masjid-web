<?php

namespace App\Events;

use BeyondCode\LaravelWebSockets\WebSockets\Channels\Channel as ChannelsChannel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Laravel\Reverb\Protocols\Pusher\Channels\Channel as PusherChannelsChannel;

class HelloEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $text;

    /**
     * Create a new event instance.
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {      
            return new Channel('hello-event');
    }

    public function broadcastWith()
    {
        return [
            "data" => $this->text
        ];
    }
}
