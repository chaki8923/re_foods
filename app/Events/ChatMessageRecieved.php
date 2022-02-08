<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatMessageRecieved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $message;
    protected $request;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('laravel03');
    }

    public function broadcastWith()
    {
 
        return [
            'message' => $this->request['message'],
            'send' => $this->request['send'],
            'recieve' => $this->request['recieve'],
        ];
    }

    /**
     * イベントブロードキャスト名
     *
     * @return string
     */
    public function broadcastAs()
    {
 
        return 'chat_event';
    }
}
