<?php

namespace App\Services;

use App\Repositories\CategoriaRepository;

class CategoriaService
{
    protected $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    /**
     * Criar categoria
     */
    public function criarCategoria(array $dados): array
    {
        try {
            $categoria = $this->categoriaRepository->criar($dados);
            
            return [
                'sucesso' => true,
                'categoria' => $categoria,
                'mensagem' => 'Categoria criada com sucesso!'
            ];
        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao criar categoria: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Atualizar categoria
     */
    public function atualizarCategoria(int $id, array $dados): array
    {
        try {
            $sucesso = $this->categoriaRepository->atualizar($id, $dados);
            
            if ($sucesso) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Categoria atualizada com sucesso!'
                ];
            }

            return [
                'sucesso' => false,
                'mensagem' => 'Categoria não encontrada.'
            ];
        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar categoria: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Deletar categoria
     */
    public function deletarCategoria(int $id): array
    {
        try {
            $sucesso = $this->categoriaRepository->deletar($id);
            
            if ($sucesso) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Categoria deletada com sucesso!'
                ];
            }

            return [
                'sucesso' => false,
                'mensagem' => 'Categoria não encontrada.'
            ];
        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao deletar categoria: ' . $e->getMessage()
            ];
        }
    }
}
