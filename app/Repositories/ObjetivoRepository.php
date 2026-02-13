<?php

namespace App\Repositories;

use App\Models\Objetivo;
use Illuminate\Support\Collection;

class ObjetivoRepository
{
    protected $model;

    public function __construct(Objetivo $model)
    {
        $this->model = $model;
    }

    /**
     * Criar novo objetivo
     */
    public function criar(array $dados): Objetivo
    {
        return $this->model->create($dados);
    }

    /**
     * Buscar objetivo por ID
     */
    public function buscarPorId(int $id): ?Objetivo
    {
        return $this->model->find($id);
    }

    /**
     * Listar objetivos do usuário
     */
    public function listarPorUsuario(int $userId): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Atualizar objetivo
     */
    public function atualizar(int $id, array $dados): bool
    {
        $objetivo = $this->model->find($id);
        if (!$objetivo) {
            return false;
        }

        return $objetivo->update($dados);
    }

    /**
     * Adicionar valor ao objetivo
     */
    public function adicionarValor(int $id, float $valor): bool
    {
        $objetivo = $this->model->find($id);
        if (!$objetivo) {
            return false;
        }

        $objetivo->valor_atual += $valor;
        return $objetivo->save();
    }

    /**
     * Deletar objetivo
     */
    public function deletar(int $id): bool
    {
        $objetivo = $this->model->find($id);
        if (!$objetivo) {
            return false;
        }

        return $objetivo->delete();
    }
}
