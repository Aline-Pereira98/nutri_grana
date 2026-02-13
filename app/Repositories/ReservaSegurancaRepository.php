<?php

namespace App\Repositories;

use App\Models\ReservaSeguranca;
use Illuminate\Support\Collection;

class ReservaSegurancaRepository
{
    protected $model;

    public function __construct(ReservaSeguranca $model)
    {
        $this->model = $model;
    }

    /**
     * Criar nova reserva de segurança
     */
    public function criar(array $dados): ReservaSeguranca
    {
        return $this->model->create($dados);
    }

    /**
     * Buscar reserva de segurança por ID
     */
    public function buscarPorId(int $id): ?ReservaSeguranca
    {
        return $this->model->find($id);
    }

    /**
     * Listar reservas de segurança do usuário
     */
    public function listarPorUsuario(int $userId): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Atualizar reserva de segurança
     */
    public function atualizar(int $id, array $dados): bool
    {
        $reserva = $this->model->find($id);
        if (!$reserva) {
            return false;
        }

        return $reserva->update($dados);
    }

    /**
     * Adicionar valor à reserva de segurança
     */
    public function adicionarValor(int $id, float $valor): bool
    {
        $reserva = $this->model->find($id);
        if (!$reserva) {
            return false;
        }

        $reserva->valor_atual += $valor;
        return $reserva->save();
    }

    /**
     * Deletar reserva de segurança
     */
    public function deletar(int $id): bool
    {
        $reserva = $this->model->find($id);
        if (!$reserva) {
            return false;
        }

        return $reserva->delete();
    }
}
