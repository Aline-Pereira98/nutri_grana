<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Criar novo usuário
     */
    public function criar(array $dados): User
    {
        $dados['password'] = Hash::make($dados['password']);
        return $this->model->create($dados);
    }

    /**
     * Buscar usuário por email
     */
    public function buscarPorEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Buscar usuário por ID
     */
    public function buscarPorId(int $id): ?User
    {
        return $this->model->find($id);
    }

    /**
     * Atualizar usuário
     */
    public function atualizar(int $id, array $dados): bool
    {
        $usuario = $this->model->find($id);
        if (!$usuario) {
            return false;
        }

        if (isset($dados['password'])) {
            $dados['password'] = Hash::make($dados['password']);
        }

        return $usuario->update($dados);
    }

    /**
     * Deletar usuário
     */
    public function deletar(int $id): bool
    {
        $usuario = $this->model->find($id);
        if (!$usuario) {
            return false;
        }

        return $usuario->delete();
    }
}
