<?php

namespace App\Repositories;

use App\Models\Categoria;
use Illuminate\Support\Collection;

class CategoriaRepository
{
    protected $model;

    public function __construct(Categoria $model)
    {
        $this->model = $model;
    }

    /**
     * Criar nova categoria
     */
    public function criar(array $dados): Categoria
    {
        return $this->model->create($dados);
    }

    /**
     * Buscar categoria por ID
     */
    public function buscarPorId(int $id): ?Categoria
    {
        return $this->model->find($id);
    }

    /**
     * Listar categorias do usuário
     */
    public function listarPorUsuario(int $userId): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->orderBy('nome', 'asc')
            ->get();
    }

    /**
     * Atualizar categoria
     */
    public function atualizar(int $id, array $dados): bool
    {
        $categoria = $this->model->find($id);
        if (!$categoria) {
            return false;
        }

        return $categoria->update($dados);
    }

    /**
     * Deletar categoria
     */
    public function deletar(int $id): bool
    {
        $categoria = $this->model->find($id);
        if (!$categoria) {
            return false;
        }

        return $categoria->delete();
    }
}
