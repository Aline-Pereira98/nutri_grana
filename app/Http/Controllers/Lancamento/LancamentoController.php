<?php

namespace App\Http\Controllers;

use App\Services\LancamentoService;
use App\Repositories\MesRepository;
use App\Repositories\CategoriaRepository;
use App\Repositories\FormaPagamentoRepository;
use App\Repositories\LancamentoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LancamentoController extends Controller
{
    protected $lancamentoService;
    protected $mesRepository;
    protected $categoriaRepository;
    protected $formaPagamentoRepository;
    protected $lancamentoRepository;

    public function __construct(
        LancamentoService $lancamentoService,
        MesRepository $mesRepository,
        CategoriaRepository $categoriaRepository,
        FormaPagamentoRepository $formaPagamentoRepository,
        LancamentoRepository $lancamentoRepository
    ) {
        $this->middleware('auth');
        $this->lancamentoService = $lancamentoService;
        $this->mesRepository = $mesRepository;
        $this->categoriaRepository = $categoriaRepository;
        $this->formaPagamentoRepository = $formaPagamentoRepository;
        $this->lancamentoRepository = $lancamentoRepository;
    }

    /**
     * Listar lançamentos
     */
    public function index()
    {
        $lancamentos = $this->lancamentoRepository->listarPorUsuario(Auth::id());
        return view('lancamentos.index', compact('lancamentos'));
    }

    /**
     * Criar lançamento
     */
    public function criar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mes_id' => 'required|exists:meses,id',
            'categoria_id' => 'nullable|exists:categorias,id',
            'forma_pagamento_id' => 'required|exists:forma_pagamentos,id',
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'data_pagamento' => 'nullable|date',
            'data_vencimento' => 'required|date',
            'essencial' => 'boolean',
            'parcelado' => 'boolean',
            'total_parcelas' => 'required_if:parcelado,1|integer|min:2|max:24',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dados = $request->all();
        $dados['user_id'] = Auth::id();

        if ($request->parcelado) {
            $resultado = $this->lancamentoService->criarLancamentoParcelado($dados);
        } else {
            $resultado = $this->lancamentoService->criarLancamentoSimples($dados);
        }

        if ($resultado['sucesso']) {
            return back()->with('sucesso', $resultado['mensagem']);
        }

        return back()->withErrors(['erro' => $resultado['mensagem']])->withInput();
    }

    /**
     * Atualizar lançamento
     */
    public function atualizar(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'categoria_id' => 'nullable|exists:categorias,id',
            'forma_pagamento_id' => 'required|exists:forma_pagamentos,id',
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'data_pagamento' => 'nullable|date',
            'data_vencimento' => 'required|date',
            'essencial' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $resultado = $this->lancamentoService->atualizarLancamento($id, $request->all());

        if ($resultado['sucesso']) {
            return back()->with('sucesso', $resultado['mensagem']);
        }

        return back()->withErrors(['erro' => $resultado['mensagem']])->withInput();
    }

    /**
     * Deletar lançamento
     */
    public function deletar(int $id)
    {
        $resultado = $this->lancamentoService->deletarLancamento($id);

        if ($resultado['sucesso']) {
            return back()->with('sucesso', $resultado['mensagem']);
        }

        return back()->withErrors(['erro' => $resultado['mensagem']]);
    }
}
