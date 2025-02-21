<?php


namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
// use BeyondCode\LaravelWebSockets\Channels\Channel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;
    public $userId;
    public $channel;

    public function __construct($userId, $message)
    {
        $this->message = $message;
        $this->userId = $userId;
        $this->channel = 'chat.' . $this->userId;

        Log::info('Evento MessageSent emitido', [
            'user' => $this->userId,
            'message' => $this->message,
            'channel' => $this->channel,
        ]);
    }

    public function broadcastOn()
    {
        return new Channel($this->channel);
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'from' => $this->userId,
            'channel' => $this->channel,
        ];
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }
}
