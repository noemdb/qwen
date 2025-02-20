<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id', // ID del usuario que envió el mensaje
        'receiver_id', // ID del usuario que recibió el mensaje
        'body',    // Contenido del mensaje
    ];

    /**
     * Relación con el modelo User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class,'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class,'receiver_id');
    }

    public static function getLastMessagesBySender($senderId) : Array
    {
        // Obtener la última fecha de mensaje por receiver_id
        $latestMessages = Message::where('sender_id', $senderId)
            ->select('receiver_id', DB::raw('MAX(created_at) as latest'))
            ->groupBy('receiver_id')
            ->get()
            ->pluck('latest', 'receiver_id'); //dd($latestMessages);

        // Obtener los mensajes correspondientes a esas fechas
        return Message::where('sender_id', $senderId)
            ->whereIn('created_at', $latestMessages->values())
            ->groupBy('receiver_id')
            ->get()
            ->keyBy('receiver_id')
            ->map(function ($message) {
                // Formatear el campo created_at
                $message->formatted_created_at = $message->created_at->format('d-m-Y H:i:s');
                return $message;
            })
            ->toArray()
            ;
    }

    public static function getLastMessagesBySender2($senderId)
    {
        // Consulta para obtener el último mensaje enviado por el sender_id para cada receiver_id
        $lastMessages = Message::whereIn('id', function ($query) use ($senderId) {
            $query->select(DB::raw('MAX(id)'))
                ->from('messages')
                ->where('sender_id', $senderId)
                ->groupBy('receiver_id');
        })->get()
        ->keyBy('receiver_id'); // Convierte la colección en un array asociativo usando receiver_id como clave

        return $lastMessages; // Devuelve el resultado como array
    }

    public static function getNameChannel($num1, $num2) {
        $numeroMenor = min($num1, $num2);
        $numeroMayor = max($num1, $num2);    
        return "chat.s:{$numeroMenor}r:{$numeroMayor}";
    }
}
