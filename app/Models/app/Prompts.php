<?php

namespace App\Models\app;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prompts extends Model
{
    use HasFactory;

    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'prompts';

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', // ID del usuario (opcional)
        'prompt', // Campo para el prompt enviado por el usuario
        'response', // Campo para la respuesta del modelo IA
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime', // Convierte created_at a un objeto Carbon
        'updated_at' => 'datetime', // Convierte updated_at a un objeto Carbon
    ];

    /**
     * Relación con el modelo User (opcional, si tienes autenticación).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para filtrar prompts por usuario (opcional).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
