<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Registrar novo usuário
     */
    public function registrar(array $dados): array
    {
        try {
            $usuario = $this->userRepository->criar($dados);
            
            Auth::login($usuario);
            
            return [
                'sucesso' => true,
                'usuario' => $usuario,
                'mensagem' => 'Usuário cadastrado com sucesso!'
            ];
        } catch (\Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao cadastrar usuário: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Realizar login
     */
    public function login(array $credenciais): array
    {
        $usuario = $this->userRepository->buscarPorEmail($credenciais['email']);

        if (!$usuario || !Hash::check($credenciais['password'], $usuario->password)) {
            return [
                'sucesso' => false,
                'mensagem' => 'Email ou senha incorretos.'
            ];
        }

        Auth::login($usuario, isset($credenciais['remember']));

        return [
            'sucesso' => true,
            'usuario' => $usuario,
            'mensagem' => 'Login realizado com sucesso!'
        ];
    }

    /**
     * Realizar logout
     */
    public function logout(): void
    {
        Auth::logout();
    }
}
