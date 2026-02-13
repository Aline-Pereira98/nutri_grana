<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nome',
        'email',
        'password',
        'data_nascimento',
        'profissao',
        'motivo_controle_financeiro',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'data_nascimento' => 'date',
        ];
    }

    /**
     * Relacionamento com Meses
     */
    public function meses(): HasMany
    {
        return $this->hasMany(Mes::class);
    }

    /**
     * Relacionamento com Lancamentos
     */
    public function lancamentos(): HasMany
    {
        return $this->hasMany(Lancamento::class);
    }

    /**
     * Relacionamento com Categorias
     */
    public function categorias(): HasMany
    {
        return $this->hasMany(Categoria::class);
    }

    /**
     * Relacionamento com Objetivos
     */
    public function objetivos(): HasMany
    {
        return $this->hasMany(Objetivo::class);
    }

    /**
     * Relacionamento com Reservas de Segurança
     */
    public function reservaSegurancas(): HasMany
    {
        return $this->hasMany(ReservaSeguranca::class);
    }
}
