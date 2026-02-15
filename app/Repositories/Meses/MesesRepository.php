<?php

namespace App\Repositories;

use App\Models\Mes;
use Illuminate\Support\Collection;

class MesRepository
{
    protected $model;

    public function __construct(Mes $model)
    {
        $this->model = $model;
    }

    /**
     * Criar novo mês
     */
    public function criar(array $dados): Mes
    {
        return $this->model->create($dados);
    }

    /**
     * Buscar mês por ID
     */
    public function buscarPorId(int $id): ?Mes
    {
        return $this->model->find($id);
    }

    /**
     * Buscar mês por usuário, ano e mês
     */
    public function buscarPorUsuarioAnoMes(int $userId, int $ano, int $mes): ?Mes
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('ano', $ano)
            ->where('mes', $mes)
            ->first();
    }

    /**
     * Buscar ou criar mês
     */
    public function buscarOuCriar(int $userId, int $ano, int $mes): Mes
    {
        return $this->model->firstOrCreate(
            [
                'user_id' => $userId,
                'ano' => $ano,
                'mes' => $mes,
            ],
            [
                'salario' => 0,
                'outros_valores' => 0,
            ]
        );
    }

    /**
     * Listar meses do usuário
     */
    public function listarPorUsuario(int $userId): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->orderBy('ano', 'desc')
            ->orderBy('mes', 'desc')
            ->get();
    }

    /**
     * Atualizar mês
     */
    public function atualizar(int $id, array $dados): bool
    {
        $mes = $this->model->find($id);
        if (!$mes) {
            return false;
        }

        return $mes->update($dados);
    }

    /**
     * Deletar mês
     */
    public function deletar(int $id): bool
    {
        $mes = $this->model->find($id);
        if (!$mes) {
            return false;
        }

        return $mes->delete();
    }
}
