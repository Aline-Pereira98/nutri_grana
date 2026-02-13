<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReservaSeguranca extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nome',
        'descricao',
        'valor_objetivo',
        'valor_atual',
    ];

    protected $casts = [
        'valor_objetivo' => 'decimal:2',
        'valor_atual' => 'decimal:2',
    ];

    /**
     * Relacionamento com User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com Reservas do Mês
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(ReservaMes::class);
    }

    /**
     * Calcula o valor faltante
     */
    public function getValorFaltanteAttribute(): float
    {
        return max(0, $this->valor_objetivo - $this->valor_atual);
    }
}
