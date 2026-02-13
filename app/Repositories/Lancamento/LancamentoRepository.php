<?php

namespace App\Repositories;

use App\Models\Lancamento;
use Illuminate\Support\Collection;

class LancamentoRepository
{
    protected $model;

    public function __construct(Lancamento $model)
    {
        $this->model = $model;
    }

    /**
     * Criar novo lançamento
     */
    public function criar(array $dados): Lancamento
    {
        return $this->model->create($dados);
    }

    /**
     * Criar múltiplos lançamentos (para parcelas)
     */
    public function criarMultiplos(array $dadosArray): Collection
    {
        $lancamentos = collect();
        foreach ($dadosArray as $dados) {
            $lancamentos->push($this->model->create($dados));
        }
        return $lancamentos;
    }

    /**
     * Buscar lançamento por ID
     */
    public function buscarPorId(int $id): ?Lancamento
    {
        return $this->model->find($id);
    }

    /**
     * Listar lançamentos do mês
     */
    public function listarPorMes(int $mesId): Collection
    {
        return $this->model
            ->where('mes_id', $mesId)
            ->with(['categoria', 'formaPagamento'])
            ->orderBy('data_vencimento', 'asc')
            ->get();
    }

    /**
     * Listar lançamentos do usuário
     */
    public function listarPorUsuario(int $userId): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->with(['categoria', 'formaPagamento', 'mes'])
            ->orderBy('data_vencimento', 'desc')
            ->get();
    }

    /**
     * Atualizar lançamento
     */
    public function atualizar(int $id, array $dados): bool
    {
        $lancamento = $this->model->find($id);
        if (!$lancamento) {
            return false;
        }

        return $lancamento->update($dados);
    }

    /**
     * Deletar lançamento
     */
    public function deletar(int $id): bool
    {
        $lancamento = $this->model->find($id);
        if (!$lancamento) {
            return false;
        }

        return $lancamento->delete();
    }

    /**
     * Calcular total de lançamentos do mês
     */
    public function calcularTotalPorMes(int $mesId): float
    {
        return $this->model
            ->where('mes_id', $mesId)
            ->sum('valor');
    }

    /**
     * Buscar parcelas por lançamento original
     */
    public function buscarParcelasPorOriginal(int $lancamentoOriginalId): Collection
    {
        return $this->model
            ->where('lancamento_original_id', $lancamentoOriginalId)
            ->get();
    }
}
