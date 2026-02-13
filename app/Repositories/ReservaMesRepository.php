<?php

namespace App\Repositories;

use App\Models\ReservaMes;
use Illuminate\Support\Collection;

class ReservaMesRepository
{
    protected $model;

    public function __construct(ReservaMes $model)
    {
        $this->model = $model;
    }

    /**
     * Criar nova reserva do mês
     */
    public function criar(array $dados): ReservaMes
    {
        return $this->model->create($dados);
    }

    /**
     * Buscar reserva do mês por ID
     */
    public function buscarPorId(int $id): ?ReservaMes
    {
        return $this->model->find($id);
    }

    /**
     * Listar reservas do mês
     */
    public function listarPorMes(int $mesId): Collection
    {
        return $this->model
            ->where('mes_id', $mesId)
            ->with(['objetivo', 'reservaSeguranca'])
            ->get();
    }

    /**
     * Atualizar reserva do mês
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
     * Deletar reserva do mês
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
