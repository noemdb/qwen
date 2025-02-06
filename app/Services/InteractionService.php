<?php

namespace App\Services;

use App\Models\app\Interaction;

class InteractionService
{
    /**
     * Guarda una nueva interacción en la base de datos.
     *
     * @param int|null $userId
     * @param string $prompt
     * @param string $response
     * @return \App\Models\Interaction
     */
    public function logInteraction($prompt, $response, $userId = null)
    {
        return Interaction::create([
            'user_id' => $userId,
            'prompt' => $prompt,
            'response' => $response,
        ]);
    }

    /**
     * Obtiene todas las interacciones de un usuario específico.
     *
     * @param int $userId
     * @return \Illuminate\Support\Collection
     */
    public function getInteractionsByUser($userId)
    {
        return Interaction::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
    }
}