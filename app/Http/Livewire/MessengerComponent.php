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
    public $selectedRecipient; // ID del destinatario seleccionado
    public $lastMessages = []; // Últimos mensajes por destinatario
    public $oldMessages = [];
    public $todayMessages = [];
    public $userId='all',$receiverId;
    public $lastMessageCount;

    // protected $listeners = ['messageReceived' => 'refreshMessages'];

    // protected $listeners = ['messageSent' => 'addMessage'];

    public function getListeners()
    {
        return [
            "echo-private:chat.{$this->userId},messageSent" => 'notifyNewMessege',
        ];
    }

    public function notifyNewMessege()
    {
        if ($this->selectedRecipient) {
            $this->loadMessages();
            $this->lastMessageCount = $this->messages->count();
        }
    }

    public function mount()
    {
        $this->lastMessageCount = 0;
        $this->messages = collect();
        $this->receiverMessages = collect();

        // Cargar mensajes iniciales si hay un destinatario seleccionado
        if ($this->selectedRecipient) {
            $this->loadMessages();
            $this->lastMessageCount = $this->messages->count();
        }

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
        if ($id) {
            $this->selectedRecipient = $id;
            $this->loadMessages();
            $this->lastMessageCount = $this->receiverMessages->count();
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
                      ->where('receiver_id', $this->selectedRecipient);
            })
            ->orWhere(function ($query) {
                $query->where('sender_id', $this->selectedRecipient)
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
            'selectedRecipient' => 'required|exists:users,id',
        ]);

        // Guardar el mensaje en la base de datos
        $message = Message::create([
            'body' => $this->messageText,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedRecipient,
        ]);

        // Emitir el evento con el remitente y el mensaje completo
        $receiver = User::find($this->selectedRecipient);
        $this->receiverId = $receiver->id;
        $userId = auth()->id(); //dd($user);
        // broadcast(new MessageSent($userId, $message))->toOthers();

        // Emite el evento
        broadcast(new MessageSent($userId, $message))->toOthers();

        // Limpiar campos y recargar mensajes
        $this->messageText = null;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->loadMessages();
    }

    public function render()
    {
        $currentMessageCount = $this->receiverMessages->count(); //dd($currentMessageCount ,$this->lastMessageCount );
        if ($currentMessageCount > $this->lastMessageCount) {
            $this->dispatchBrowserEvent('new-message-received');
            $this->lastMessageCount = $currentMessageCount;
            // $this->loadLastMessages();
        }
        $this->loadLastMessages();

        return view('livewire.messenger-component');
    }    

    public function refreshMessages()
    {
        if ($this->selectedRecipient) {
            $this->loadMessages();
        }
    }

}