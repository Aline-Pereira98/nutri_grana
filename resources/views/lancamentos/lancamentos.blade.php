@extends('layouts.app')

@section('title', 'Lançamentos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Lançamentos</h1>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Todos os Lançamentos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Categoria</th>
                                <th>Valor</th>
                                <th>Mês</th>
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
                                    <td>{{ $lancamento->mes->nome_mes }} / {{ $lancamento->mes->ano }}</td>
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
                                    <td colspan="9" class="text-center text-muted">Nenhum lançamento cadastrado</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
