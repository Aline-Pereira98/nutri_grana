<?php

namespace App\Http\Controllers;

use App\Services\MesService;
use App\Repositories\MesRepository;
use App\Repositories\LancamentoRepository;
use App\Repositories\CategoriaRepository;
use App\Repositories\FormaPagamentoRepository;
use App\Repositories\ObjetivoRepository;
use App\Repositories\ReservaSegurancaRepository;
use App\Repositories\ReservaMesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MesController extends Controller
{
    protected $mesService;
    protected $mesRepository;
    protected $lancamentoRepository;
    protected $categoriaRepository;
    protected $formaPagamentoRepository;
    protected $objetivoRepository;
    protected $reservaSegurancaRepository;
    protected $reservaMesRepository;

    public function __construct(
        MesService $mesService,
        MesRepository $mesRepository,
        LancamentoRepository $lancamentoRepository,
        CategoriaRepository $categoriaRepository,
        FormaPagamentoRepository $formaPagamentoRepository,
        ObjetivoRepository $objetivoRepository,
        ReservaSegurancaRepository $reservaSegurancaRepository,
        ReservaMesRepository $reservaMesRepository
    ) {
        $this->middleware('auth');
        $this->mesService = $mesService;
        $this->mesRepository = $mesRepository;
        $this->lancamentoRepository = $lancamentoRepository;
        $this->categoriaRepository = $categoriaRepository;
        $this->formaPagamentoRepository = $formaPagamentoRepository;
        $this->objetivoRepository = $objetivoRepository;
        $this->reservaSegurancaRepository = $reservaSegurancaRepository;
        $this->reservaMesRepository = $reservaMesRepository;
    }

    /**
     * Listar meses
     */
    public function index()
    {
        $meses = $this->mesRepository->listarPorUsuario(Auth::id());
        return view('meses.index', compact('meses'));
    }

    /**
     * Exibir mês específico
     */
    public function mostrar(Request $request, int $ano, int $mes)
    {
        $mesModel = $this->mesService->buscarOuCriarMes(Auth::id(), $ano, $mes);
        $lancamentos = $this->lancamentoRepository->listarPorMes($mesModel->id);
        $categorias = $this->categoriaRepository->listarPorUsuario(Auth::id());
        $formasPagamento = $this->formaPagamentoRepository->listarAtivas();
        $objetivos = $this->objetivoRepository->listarPorUsuario(Auth::id());
        $reservasSeguranca = $this->reservaSegurancaRepository->listarPorUsuario(Auth::id());
        $reservasMes = $this->reservaMesRepository->listarPorMes($mesModel->id);
        $totais = $this->mesService->calcularTotaisMes($mesModel->id);

        return view('meses.mostrar', compact(
            'mesModel',
            'lancamentos',
            'categorias',
            'formasPagamento',
            'objetivos',
            'reservasSeguranca',
            'reservasMes',
            'totais'
        ));
    }

    /**
     * Atualizar informações do mês
     */
    public function atualizar(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'salario' => 'nullable|numeric|min:0',
            'outros_valores' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $resultado = $this->mesService->atualizarMes($id, $request->only(['salario', 'outros_valores']));

        if ($resultado['sucesso']) {
            return back()->with('sucesso', $resultado['mensagem']);
        }

        return back()->withErrors(['erro' => $resultado['mensagem']])->withInput();
    }

    /**
     * Adicionar reserva ao mês
     */
    public function adicionarReserva(Request $request, int $mesId)
    {
        $validator = Validator::make($request->all(), [
            'valor' => 'required|numeric|min:0',
            'objetivo_id' => 'nullable|exists:objetivos,id',
            'reserva_seguranca_id' => 'nullable|exists:reserva_segurancas,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dados = $request->all();
        $dados['mes_id'] = $mesId;

        $resultado = $this->mesService->adicionarReserva($mesId, $dados);

        if ($resultado['sucesso']) {
            return back()->with('sucesso', $resultado['mensagem']);
        }

        return back()->withErrors(['erro' => $resultado['mensagem']])->withInput();
    }
}
