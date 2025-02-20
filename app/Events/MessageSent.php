<?php


namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;
    public $userId;
    public $receiverId;

    public function __construct($userId,$receiverId, $message)
    {
        $this->message = $message;
        $this->userId = $userId;
        $this->receiverId = $receiverId;

        Log::info('Evento MessageSent emitido', [
            'user' => $this->userId,
            'receiver' => $this->receiverId,
            'message' => $message,
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('chat.s' . $this->userId.'r:'.$this->receiverId);
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
