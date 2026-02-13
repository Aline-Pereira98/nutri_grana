<?php

namespace App\Repositories;

use App\Models\FormaPagamento;
use Illuminate\Support\Collection;

class FormaPagamentoRepository
{
    protected $model;

    public function __construct(FormaPagamento $model)
    {
        $this->model = $model;
    }

    /**
     * Criar nova forma de pagamento
     */
    public function criar(array $dados): FormaPagamento
    {
        return $this->model->create($dados);
    }

    /**
     * Buscar forma de pagamento por ID
     */
    public function buscarPorId(int $id): ?FormaPagamento
    {
        return $this->model->find($id);
    }

    /**
     * Listar formas de pagamento ativas
     */
    public function listarAtivas(): Collection
    {
        return $this->model
            ->where('ativo', true)
            ->orderBy('nome', 'asc')
            ->get();
    }

    /**
     * Listar todas as formas de pagamento
     */
    public function listarTodas(): Collection
    {
        return $this->model
            ->orderBy('nome', 'asc')
            ->get();
    }

    /**
     * Atualizar forma de pagamento
     */
    public function atualizar(int $id, array $dados): bool
    {
        $formaPagamento = $this->model->find($id);
        if (!$formaPagamento) {
            return false;
        }

        return $formaPagamento->update($dados);
    }

    /**
     * Deletar forma de pagamento
     */
    public function deletar(int $id): bool
    {
        $formaPagamento = $this->model->find($id);
        if (!$formaPagamento) {
            return false;
        }

        return $formaPagamento->delete();
    }
}
