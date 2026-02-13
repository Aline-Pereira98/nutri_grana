<?php

namespace App\Services;

use App\Repositories\LancamentoRepository;
use App\Repositories\MesRepository;
use Carbon\Carbon;

class LancamentoService
{
    protected $lancamentoRepository;
    protected $mesRepository;

    public function __construct(
        LancamentoRepository $lancamentoRepository,
        MesRepository $mesRepository
    ) {
        $this->lancamentoRepository = $lancamentoRepository;
        $this->mesRepository = $mesRepository;
    }

    /**
     * Criar lançamento simples
     */
    public function criarLancamentoSimples(array $dados): array
    {
        try {
            $lancamento = $this->lancamentoRepository->criar($dados);
            
            return [
                'sucesso' => true,
                'lancamento' => $lancamento,
                'mensagem' => 'Lançamento criado com sucesso!'
            ];
        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao criar lançamento: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Criar lançamento parcelado
     */
    public function criarLancamentoParcelado(array $dados): array
    {
        try {
            $valorParcela = $dados['valor'] / $dados['total_parcelas'];
            $dataVencimento = Carbon::parse($dados['data_vencimento']);
            $lancamentos = [];

            // Criar primeiro lançamento (original)
            $dadosOriginal = $dados;
            $dadosOriginal['parcela_atual'] = 1;
            $dadosOriginal['parcelado'] = true;
            $dadosOriginal['valor'] = $valorParcela;
            
            $lancamentoOriginal = $this->lancamentoRepository->criar($dadosOriginal);
            $lancamentos[] = $lancamentoOriginal;

            // Criar parcelas subsequentes
            for ($i = 2; $i <= $dados['total_parcelas']; $i++) {
                $dataParcela = $dataVencimento->copy()->addMonths($i - 1);
                $ano = $dataParcela->year;
                $mes = $dataParcela->month;

                // Buscar ou criar o mês
                $mesModel = $this->mesRepository->buscarOuCriar(
                    $dados['user_id'],
                    $ano,
                    $mes
                );

                $dadosParcela = [
                    'user_id' => $dados['user_id'],
                    'mes_id' => $mesModel->id,
                    'categoria_id' => $dados['categoria_id'] ?? null,
                    'forma_pagamento_id' => $dados['forma_pagamento_id'],
                    'descricao' => $dados['descricao'] . " ({$i}/{$dados['total_parcelas']})",
                    'valor' => $valorParcela,
                    'data_vencimento' => $dataParcela->format('Y-m-d'),
                    'essencial' => $dados['essencial'] ?? false,
                    'parcelado' => true,
                    'parcela_atual' => $i,
                    'total_parcelas' => $dados['total_parcelas'],
                    'lancamento_original_id' => $lancamentoOriginal->id,
                ];

                $lancamento = $this->lancamentoRepository->criar($dadosParcela);
                $lancamentos[] = $lancamento;
            }

            return [
                'sucesso' => true,
                'lancamentos' => $lancamentos,
                'mensagem' => 'Lançamento parcelado criado com sucesso!'
            ];
        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao criar lançamento parcelado: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Atualizar lançamento
     */
    public function atualizarLancamento(int $id, array $dados): array
    {
        try {
            $sucesso = $this->lancamentoRepository->atualizar($id, $dados);
            
            if ($sucesso) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Lançamento atualizado com sucesso!'
                ];
            }

            return [
                'sucesso' => false,
                'mensagem' => 'Lançamento não encontrado.'
            ];
        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar lançamento: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Deletar lançamento
     */
    public function deletarLancamento(int $id): array
    {
        try {
            $lancamento = $this->lancamentoRepository->buscarPorId($id);
            
            if (!$lancamento) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Lançamento não encontrado.'
                ];
            }

            // Se for parcelado, deletar todas as parcelas
            if ($lancamento->parcelado) {
                if ($lancamento->lancamento_original_id) {
                    // É uma parcela, deletar todas as parcelas relacionadas
                    $original = $this->lancamentoRepository->buscarPorId($lancamento->lancamento_original_id);
                    if ($original) {
                        $parcelas = $this->lancamentoRepository->buscarParcelasPorOriginal($original->id);
                        foreach ($parcelas as $parcela) {
                            $this->lancamentoRepository->deletar($parcela->id);
                        }
                        $this->lancamentoRepository->deletar($original->id);
                    }
                } else {
                    // É o original, deletar todas as parcelas
                    $parcelas = $this->lancamentoRepository->buscarParcelasPorOriginal($lancamento->id);
                    foreach ($parcelas as $parcela) {
                        $this->lancamentoRepository->deletar($parcela->id);
                    }
                    $this->lancamentoRepository->deletar($lancamento->id);
                }
            } else {
                $this->lancamentoRepository->deletar($id);
            }

            return [
                'sucesso' => true,
                'mensagem' => 'Lançamento deletado com sucesso!'
            ];
        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao deletar lançamento: ' . $e->getMessage()
            ];
        }
    }
}
