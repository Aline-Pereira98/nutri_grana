<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservaMes extends Model
{
    use HasFactory;

    protected $fillable = [
        'mes_id',
        'objetivo_id',
        'reserva_seguranca_id',
        'valor',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
    ];

    /**
     * Relacionamento com Mes
     */
    public function mes(): BelongsTo
    {
        return $this->belongsTo(Mes::class);
    }

    /**
     * Relacionamento com Objetivo
     */
    public function objetivo(): BelongsTo
    {
        return $this->belongsTo(Objetivo::class);
    }

    /**
     * Relacionamento com ReservaSeguranca
     */
    public function reservaSeguranca(): BelongsTo
    {
        return $this->belongsTo(ReservaSeguranca::class);
    }
}
