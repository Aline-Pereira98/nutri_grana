<?php

namespace App\Http\Controllers;

use App\Services\UsuarioService;
use App\Repositories\ObjetivoRepository;
use App\Repositories\ReservaSegurancaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    protected $perfilService;
    protected $objetivoRepository;
    protected $reservaSegurancaRepository;

    public function __construct(
        UsuarioService $perfilService,
        ObjetivoRepository $objetivoRepository,
    ) {
        $this->middleware('auth');
        $this->perfilService = $perfilService;
        $this->objetivoRepository = $objetivoRepository;
    }

    /**
     * Exibir perfil do usuário
     */
    public function index()
    {
        $usuario = Auth::user();
        $objetivos = $this->objetivoRepository->listarPorUsuario($usuario->id);
        $reservasSeguranca = $this->reservaSegurancaRepository->listarPorUsuario($usuario->id);

        return view('usuario.index', compact('usuario'));
    }

    /**
     * Atualizar perfil
     */
    public function atualizar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'data_nascimento' => 'required|date',
            'profissao' => 'nullable|string|max:255',
            'motivo_controle_financeiro' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dados = $request->only(['nome', 'email', 'data_nascimento', 'profissao', 'motivo_controle_financeiro']);
        if ($request->filled('password')) {
            $dados['password'] = $request->password;
        }

        $resultado = $this->perfilService->atualizarPerfil(Auth::id(), $dados);

        if ($resultado['sucesso']) {
            return back()->with('sucesso', $resultado['mensagem']);
        }

        return back()->withErrors(['erro' => $resultado['mensagem']])->withInput();
    }

    /**
     * Criar objetivo
     */
    public function criarObjetivo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'valor_objetivo' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dados = $request->all();
        $dados['user_id'] = Auth::id();
        $dados['valor_atual'] = 0;

        $resultado = $this->perfilService->criarObjetivo($dados);

        if ($resultado['sucesso']) {
            return back()->with('sucesso', $resultado['mensagem']);
        }

        return back()->withErrors(['erro' => $resultado['mensagem']])->withInput();
    }

    /**
     * Criar reserva de segurança
     */
    public function criarReservaSeguranca(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'valor_objetivo' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dados = $request->all();
        $dados['user_id'] = Auth::id();
        $dados['valor_atual'] = 0;

        $resultado = $this->perfilService->criarReservaSeguranca($dados);

        if ($resultado['sucesso']) {
            return back()->with('sucesso', $resultado['mensagem']);
        }

        return back()->withErrors(['erro' => $resultado['mensagem']])->withInput();
    }
}
