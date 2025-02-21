<?php

namespace App\Http\Livewire;

use App\Events\MensajeEnviado;
use App\Events\MessageSent;
use Livewire\Component;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessengerComponent extends Component
{
    public $messageText = '';
    public $messages;
    public $receiverMessages;
    public $recipients = []; // Lista de usuarios disponibles
    public $lastMessages = []; // Últimos mensajes por destinatario
    public $oldMessages = [];
    public $todayMessages = [];
    public $userId = null, $receiverId = null;
    public $lastMessageCount,$showNewMessageSentNotification;

    public function getListeners()
    {
        return [
            "echo:chat.{$this->userId},MessageSent" => 'notifyNewMessege',
        ];
    }

    public function notifyNewMessege()
    {
        $this->showNewMessageSentNotification = true;
        $this->loadMessages();
        $this->lastMessageCount = $this->messages->count();
    }

    public function mount()
    {
        $this->userId = auth()->id();
        $this->lastMessageCount = 0;
        $this->messages = collect();
        $this->receiverMessages = collect();

        // Cargar lista de usuarios disponibles como destinatarios
        $this->recipients = User::where('id', '!=', auth()->id())->pluck('name', 'id')->toArray();

        $this->loadLastMessages();
        $this->loadReceiverMessages();
    }

    public function loadLastMessages()
    {
        $this->lastMessages = Message::getLastMessagesBySender(auth()->id()); //dd($this->lastMessages);
    }

    public function selectRecipient($id)
    {
        $receiver = User::findOrFail($id);
        if ($receiver) {
            $this->receiverId = $receiver->id;
            $this->loadMessages();
            $this->lastMessageCount = $this->receiverMessages->count();
            // $channel = Message::getNameChannel($this->userId, $this->receiverId);
            // $this->emit('suscribeChannel', $this->receiverId);
        }
    }

    public function loadReceiverMessages()
    {
        $this->receiverMessages = Message::where('receiver_id', auth()->id())
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function loadMessages()
    {
        // Cargar todos los mensajes entre el usuario autenticado y el destinatario seleccionado
        $this->messages = Message::where(function ($query) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $this->receiverId);
        })
            ->orWhere(function ($query) {
                $query->where('sender_id', $this->receiverId)
                    ->where('receiver_id', auth()->id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Separar mensajes en "antiguos" y "de hoy"
        $this->todayMessages = $this->messages->filter(function ($message) {
            return $message->created_at->isToday();
        });

        $this->oldMessages = $this->messages->filter(function ($message) {
            return !$message->created_at->isToday();
        });

        $this->loadReceiverMessages();

        $this->loadLastMessages();
    }

    public function sendMessage()
    {
        // Validar el mensaje y el destinatario
        $this->validate([
            'messageText' => 'required|string|max:255',
            'receiverId' => 'required|exists:users,id',
        ]);

        // Guardar el mensaje en la base de datos
        $message = Message::create([
            'body' => $this->messageText,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->receiverId,
        ]);

        // Emitir el evento con el remitente y el mensaje completo
        $receiver = User::find($this->receiverId);
        $this->receiverId = $receiver->id;
        $userId = auth()->id(); //dd($user);
        $receiverId = $receiver->id; //dd($user);

        // Emite el evento
        broadcast(new MessageSent($receiverId, $message))->toOthers();

        // Limpiar campos y recargar mensajes
        $this->messageText = null;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->loadMessages();

        $this->emit('sendMessageFromBackEnd', $message->body);
    }

    public function render()
    {
        $this->loadLastMessages();
        return view('livewire.messenger-component');
    }

    public function refreshMessages()
    {
        if ($this->receiverId) {
            $this->loadMessages();
        }
    }
}
