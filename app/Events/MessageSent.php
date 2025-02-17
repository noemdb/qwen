<?php


namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;
    public $userId;

    public function __construct($userId, $message)
    {
        $this->message = $message;
        $this->userId = $userId;

        Log::info('Evento MessageSent emitido', [
            'user' => $this->userId,
            'message' => $message,
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->userId);
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'from' => $this->userId,
        ];
    }

    public function broadcastAs()
    {
        return 'MessageSent';
    }
}
