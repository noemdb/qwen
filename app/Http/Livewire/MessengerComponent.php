<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\User;

class MessengerComponent extends Component
{
    public $messageText = '';
    public $messages = [];
    public $recipients = []; // Lista de usuarios disponibles
    public $selectedRecipient; // ID del destinatario seleccionado
    public $lastMessages = []; // Últimos mensajes por destinatario

    public function mount()
    {
        // Cargar mensajes iniciales si hay un destinatario seleccionado
        if ($this->selectedRecipient) {
            $this->loadMessages();
        }

        // Cargar lista de usuarios disponibles como destinatarios
        $this->recipients = User::where('id', '!=', auth()->id())->pluck('name', 'id')->toArray();

        // Cargar los últimos mensajes con cada destinatario
        $this->loadLastMessages();
    }

    public function loadLastMessages()
    {
        // Obtener el último mensaje enviado o recibido con cada destinatario
        $this->lastMessages = Message::whereIn('receiver_id', array_keys($this->recipients))
            ->orWhereIn('sender_id', array_keys($this->recipients))
            ->where(function ($query) {
                $query->where('sender_id', auth()->id())
                      ->orWhere('receiver_id', auth()->id());
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) {
                // Agrupar por el ID del destinatario (el otro participante en la conversación)
                return $message->sender_id === auth()->id() ? $message->receiver_id : $message->sender_id;
            })
            ->map(function ($group) {
                // Tomar el primer mensaje de cada grupo (el más reciente)
                return $group->first();
            });
    }

    public function selectRecipient($id)
    {
        $this->selectedRecipient = $id;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        // Cargar mensajes entre el usuario autenticado y el destinatario seleccionado
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
    }

    public function sendMessage()
    {
        // Validar el mensaje y el destinatario
        $this->validate([
            'messageText' => 'required|string|max:255',
            'selectedRecipient' => 'required|exists:users,id',
        ]);

        // Guardar el mensaje en la base de datos
        Message::create([
            'body' => $this->messageText,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedRecipient,
        ]);

        // Limpiar el campo de texto
        $this->messageText = '';

        // Recargar mensajes y últimos mensajes
        $this->loadMessages();
        $this->loadLastMessages();
    }

    public function render()
    {
        return view('livewire.messenger-component');
    }
}