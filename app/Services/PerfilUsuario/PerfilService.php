<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\ObjetivoRepository;
use App\Repositories\ReservaSegurancaRepository;

class PerfilService
{
    protected $userRepository;
    protected $objetivoRepository;
    protected $reservaSegurancaRepository;

    public function __construct(
        UserRepository $userRepository,
        ObjetivoRepository $objetivoRepository,
        ReservaSegurancaRepository $reservaSegurancaRepository
    ) {
        $this->userRepository = $userRepository;
        $this->objetivoRepository = $objetivoRepository;
        $this->reservaSegurancaRepository = $reservaSegurancaRepository;
    }

    /**
     * Atualizar perfil do usuário
     */
    public function atualizarPerfil(int $userId, array $dados): array
    {
        try {
            $sucesso = $this->userRepository->atualizar($userId, $dados);
            
            if ($sucesso) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Perfil atualizado com sucesso!'
                ];
            }

            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar perfil.'
            ];
        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar perfil: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Criar objetivo
     */
    public function criarObjetivo(array $dados): array
    {
        try {
            $objetivo = $this->objetivoRepository->criar($dados);
            
            return [
                'sucesso' => true,
                'objetivo' => $objetivo,
                'mensagem' => 'Objetivo criado com sucesso!'
            ];
        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao criar objetivo: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Criar reserva de segurança
     */
    public function criarReservaSeguranca(array $dados): array
    {
        try {
            $reserva = $this->reservaSegurancaRepository->criar($dados);
            
            return [
                'sucesso' => true,
                'reserva' => $reserva,
                'mensagem' => 'Reserva de segurança criada com sucesso!'
            ];
        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao criar reserva de segurança: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Atualizar objetivo
     */
    public function atualizarObjetivo(int $id, array $dados): array
    {
        try {
            $sucesso = $this->objetivoRepository->atualizar($id, $dados);
            
            if ($sucesso) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Objetivo atualizado com sucesso!'
                ];
            }

            return [
                'sucesso' => false,
                'mensagem' => 'Objetivo não encontrado.'
            ];
        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar objetivo: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Atualizar reserva de segurança
     */
    public function atualizarReservaSeguranca(int $id, array $dados): array
    {
        try {
            $sucesso = $this->reservaSegurancaRepository->atualizar($id, $dados);
            
            if ($sucesso) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Reserva de segurança atualizada com sucesso!'
                ];
            }

            return [
                'sucesso' => false,
                'mensagem' => 'Reserva de segurança não encontrada.'
            ];
        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar reserva de segurança: ' . $e->getMessage()
            ];
        }
    }
}
