<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Exibir formulário de login
     */
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    /**
     * Exibir formulário de cadastro
     */
    public function mostrarCadastro()
    {
        return view('auth.cadastro');
    }

    /**
     * Processar login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $resultado = $this->authService->login($request->only(['email', 'password', 'remember']));

        if ($resultado['sucesso']) {
            return redirect()->route('home')->with('sucesso', $resultado['mensagem']);
        }

        return back()->withErrors(['email' => $resultado['mensagem']])->withInput();
    }

    /**
     * Processar cadastro
     */
    public function cadastro(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'data_nascimento' => 'required|date',
            'profissao' => 'nullable|string|max:255',
            'motivo_controle_financeiro' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $resultado = $this->authService->registrar($request->all());

        if ($resultado['sucesso']) {
            return redirect()->route('home')->with('sucesso', $resultado['mensagem']);
        }

        return back()->withErrors(['erro' => $resultado['mensagem']])->withInput();
    }

    /**
     * Processar logout
     */
    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('login')->with('sucesso', 'Logout realizado com sucesso!');
    }
}
