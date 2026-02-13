@extends('layouts.app')

@section('title', $mesModel->nome_mes . ' ' . $mesModel->ano)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $mesModel->nome_mes }} / {{ $mesModel->ano }}</h1>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Informações do Mês</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('meses.atualizar', $mesModel->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="salario" class="form-label">Salário</label>
                        <input type="number" step="0.01" class="form-control" id="salario" name="salario" 
                               value="{{ old('salario', $mesModel->salario) }}">
                    </div>
                    <div class="mb-3">
                        <label for="outros_valores" class="form-label">Outros Valores</label>
                        <input type="number" step="0.01" class="form-control" id="outros_valores" name="outros_valores" 
                               value="{{ old('outros_valores', $mesModel->outros_valores) }}">
                    </div>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Resumo</h5>
            </div>
            <div class="card-body">
                <p><strong>Total Entradas:</strong> R$ {{ number_format($totais['total_entradas'] ?? 0, 2, ',', '.') }}</p>
                <p><strong>Total Saídas:</strong> R$ {{ number_format($totais['total_saidas'] ?? 0, 2, ',', '.') }}</p>
                <p><strong>Total Reservas:</strong> R$ {{ number_format($totais['total_reservas'] ?? 0, 2, ',', '.') }}</p>
                <p><strong>Restante:</strong> R$ {{ number_format($totais['restante'] ?? 0, 2, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Adicionar Lançamento</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('lancamentos.criar') }}">
                    @csrf
                    <input type="hidden" name="mes_id" value="{{ $mesModel->id }}">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="descricao" name="descricao" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="valor" class="form-label">Valor</label>
                            <input type="number" step="0.01" class="form-control" id="valor" name="valor" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="categoria_id" class="form-label">Categoria</label>
                            <select class="form-select" id="categoria_id" name="categoria_id">
                                <option value="">Selecione</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="forma_pagamento_id" class="form-label">Forma de Pagamento</label>
                            <select class="form-select" id="forma_pagamento_id" name="forma_pagamento_id" required>
                                @foreach($formasPagamento as $forma)
                                    <option value="{{ $forma->id }}">{{ $forma->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="data_vencimento" class="form-label">Data de Vencimento</label>
                            <input type="date" class="form-control" id="data_vencimento" name="data_vencimento" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="data_pagamento" class="form-label">Data de Pagamento</label>
                            <input type="date" class="form-control" id="data_pagamento" name="data_pagamento">
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="essencial" name="essencial" value="1">
                                <label class="form-check-label" for="essencial">
                                    Essencial
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="parcelado" name="parcelado" value="1">
                                <label class="form-check-label" for="parcelado">
                                    Parcelado
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3" id="total_parcelas_div" style="display: none;">
                            <label for="total_parcelas" class="form-label">Total de Parcelas</label>
                            <input type="number" class="form-control" id="total_parcelas" name="total_parcelas" min="2" max="24">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Adicionar Lançamento</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Lançamentos do Mês</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Categoria</th>
                                <th>Valor</th>
                                <th>Data Vencimento</th>
                                <th>Data Pagamento</th>
                                <th>Forma Pagamento</th>
                                <th>Essencial</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lancamentos as $lancamento)
                                <tr>
                                    <td>{{ $lancamento->descricao }}</td>
                                    <td>{{ $lancamento->categoria->nome ?? '-' }}</td>
                                    <td>R$ {{ number_format($lancamento->valor, 2, ',', '.') }}</td>
                                    <td>{{ $lancamento->data_vencimento->format('d/m/Y') }}</td>
                                    <td>{{ $lancamento->data_pagamento ? $lancamento->data_pagamento->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $lancamento->formaPagamento->nome }}</td>
                                    <td>{{ $lancamento->essencial ? 'Sim' : 'Não' }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('lancamentos.deletar', $lancamento->id) }}" 
                                              style="display: inline;" onsubmit="return confirm('Tem certeza?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Nenhum lançamento cadastrado</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Reservas do Mês</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('meses.adicionar-reserva', $mesModel->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="valor_reserva" class="form-label">Valor</label>
                        <input type="number" step="0.01" class="form-control" id="valor_reserva" name="valor" required>
                    </div>
                    <div class="mb-3">
                        <label for="objetivo_id" class="form-label">Objetivo (opcional)</label>
                        <select class="form-select" id="objetivo_id" name="objetivo_id">
                            <option value="">Selecione</option>
                            @foreach($objetivos as $objetivo)
                                <option value="{{ $objetivo->id }}">{{ $objetivo->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="reserva_seguranca_id" class="form-label">Reserva de Segurança (opcional)</label>
                        <select class="form-select" id="reserva_seguranca_id" name="reserva_seguranca_id">
                            <option value="">Selecione</option>
                            @foreach($reservasSeguranca as $reserva)
                                <option value="{{ $reserva->id }}">{{ $reserva->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Adicionar Reserva</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('parcelado').addEventListener('change', function() {
        const totalParcelasDiv = document.getElementById('total_parcelas_div');
        if (this.checked) {
            totalParcelasDiv.style.display = 'block';
        } else {
            totalParcelasDiv.style.display = 'none';
        }
    });
</script>
@endpush
