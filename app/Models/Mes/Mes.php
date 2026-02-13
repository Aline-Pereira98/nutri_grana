<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mes extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ano',
        'mes',
        'salario',
        'outros_valores',
    ];

    protected $casts = [
        'ano' => 'integer',
        'mes' => 'integer',
        'salario' => 'decimal:2',
        'outros_valores' => 'decimal:2',
    ];

    /**
     * Relacionamento com User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com Lancamentos
     */
    public function lancamentos(): HasMany
    {
        return $this->hasMany(Lancamento::class);
    }

    /**
     * Relacionamento com Reservas do Mês
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(ReservaMes::class);
    }

    /**
     * Retorna o nome do mês em português
     */
    public function getNomeMesAttribute(): string
    {
        $meses = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro',
        ];

        return $meses[$this->mes] ?? '';
    }
}
