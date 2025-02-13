<?php

namespace App\Events;

use App\Models\Mensaje;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Queue\SerializesModels;

class MensajeEnviado implements ShouldBroadcast
{
    use SerializesModels;

    public $mensaje;

    /**
     * Crear una nueva instancia de evento.
     *
     * @param  \App\Models\Mensaje  $mensaje
     * @return void
     */
    public function __construct(Message $mensaje)
    {
        $this->mensaje = $mensaje;
    }

    /**
     * Obtener los canales por los que debe transmitirse el evento.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat'); // Canal 'chat' para la transmisión
    }

    /**
     * Obtener los datos que se transmitirán.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'usuario' => $this->mensaje->usuario,
            'contenido' => $this->mensaje->contenido,
            'created_at' => $this->mensaje->created_at->toDateTimeString(),
        ];
    }
}
