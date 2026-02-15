<?php

namespace App\Services;

use App\Repositories\MesesRepository;
use App\Repositories\LancamentosRepository;
use App\Repositories\ReservaMesRepository;
use App\Repositories\ObjetivoRepository;
use App\Repositories\ReservaSegurancaRepository;

class MesesService
{
    protected $mesRepository;
    protected $lancamentoRepository;
    protected $reservaMesRepository;
    protected $objetivoRepository;
    protected $reservaSegurancaRepository;

    public function __construct(
        MesRepository $mesRepository,
        LancamentoRepository $lancamentoRepository,
        ReservaMesRepository $reservaMesRepository,
        ObjetivoRepository $objetivoRepository,
        ReservaSegurancaRepository $reservaSegurancaRepository
    ) {
        $this->mesRepository = $mesRepository;
        $this->lancamentoRepository = $lancamentoRepository;
        $this->reservaMesRepository = $reservaMesRepository;
        $this->objetivoRepository = $objetivoRepository;
        $this->reservaSegurancaRepository = $reservaSegurancaRepository;
    }

    /**
     * Buscar ou criar mês
     */
    public function buscarOuCriarMes(int $userId, int $ano, int $mes)
    {
        return $this->mesRepository->buscarOuCriar($userId, $ano, $mes);
    }

    /**
     * Atualizar informações do mês
     */
    public function atualizarMes(int $id, array $dados): array
    {
        try {
            $sucesso = $this->mesRepository->atualizar($id, $dados);
            
            if ($sucesso) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Mês atualizado com sucesso!'
                ];
            }

            return [
                'sucesso' => false,
                'mensagem' => 'Mês não encontrado.'
            ];
        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar mês: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Calcular totais do mês
     */
    public function calcularTotaisMes(int $mesId): array
    {
        $mes = $this->mesRepository->buscarPorId($mesId);
        if (!$mes) {
            return [];
        }

        $totalLancamentos = $this->lancamentoRepository->calcularTotalPorMes($mesId);
        $totalReservas = $this->reservaMesRepository->listarPorMes($mesId)->sum('valor');
        
        $totalEntradas = $mes->salario + $mes->outros_valores;
        $totalSaidas = $totalLancamentos;
        $restante = $totalEntradas - $totalSaidas - $totalReservas;

        return [
            'total_entradas' => $totalEntradas,
            'total_saidas' => $totalSaidas,
            'total_reservas' => $totalReservas,
            'restante' => $restante,
        ];
    }

    /**
     * Adicionar reserva ao mês
     */
    public function adicionarReserva(int $mesId, array $dados): array
    {
        try {
            $reserva = $this->reservaMesRepository->criar($dados);
            
            // Atualizar valor atual do objetivo ou reserva de segurança
            if (isset($dados['objetivo_id'])) {
                $this->objetivoRepository->adicionarValor($dados['objetivo_id'], $dados['valor']);
            }
            
            if (isset($dados['reserva_seguranca_id'])) {
                $this->reservaSegurancaRepository->adicionarValor($dados['reserva_seguranca_id'], $dados['valor']);
            }

            return [
                'sucesso' => true,
                'reserva' => $reserva,
                'mensagem' => 'Reserva adicionada com sucesso!'
            ];
        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao adicionar reserva: ' . $e->getMessage()
            ];
        }
    }
}
