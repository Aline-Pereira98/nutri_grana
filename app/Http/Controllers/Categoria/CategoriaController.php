<?php

namespace App\Http\Controllers;

use App\Services\CategoriaService;
use App\Repositories\CategoriaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    protected $categoriaService;
    protected $categoriaRepository;

    public function __construct(
        CategoriaService $categoriaService,
        CategoriaRepository $categoriaRepository
    ) {
        $this->middleware('auth');
        $this->categoriaService = $categoriaService;
        $this->categoriaRepository = $categoriaRepository;
    }

    /**
     * Listar categorias
     */
    public function index()
    {
        $categorias = $this->categoriaRepository->listarPorUsuario(Auth::id());
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Criar categoria
     */
    public function criar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dados = $request->all();
        $dados['user_id'] = Auth::id();

        $resultado = $this->categoriaService->criarCategoria($dados);

        if ($resultado['sucesso']) {
            return back()->with('sucesso', $resultado['mensagem']);
        }

        return back()->withErrors(['erro' => $resultado['mensagem']])->withInput();
    }

    /**
     * Atualizar categoria
     */
    public function atualizar(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $resultado = $this->categoriaService->atualizarCategoria($id, $request->all());

        if ($resultado['sucesso']) {
            return back()->with('sucesso', $resultado['mensagem']);
        }

        return back()->withErrors(['erro' => $resultado['mensagem']])->withInput();
    }

    /**
     * Deletar categoria
     */
    public function deletar(int $id)
    {
        $resultado = $this->categoriaService->deletarCategoria($id);

        if ($resultado['sucesso']) {
            return back()->with('sucesso', $resultado['mensagem']);
        }

        return back()->withErrors(['erro' => $resultado['mensagem']]);
    }
}
