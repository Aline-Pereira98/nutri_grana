@extends('layouts.app')

@section('title', 'Meses')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Meses</h1>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Selecione um mês para gerenciar</h5>
                <div class="row">
                    @for($mes = 1; $mes <= 12; $mes++)
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('meses.mostrar', ['ano' => date('Y'), 'mes' => $mes]) }}" 
                               class="btn btn-outline-primary w-100">
                                {{ \Carbon\Carbon::create(null, $mes, 1)->locale('pt_BR')->monthName }}
                            </a>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Meses Cadastrados</h5>
            </div>
            <div class="card-body">
                @if($meses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Mês/Ano</th>
                                    <th>Salário</th>
                                    <th>Outros Valores</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($meses as $mes)
                                    <tr>
                                        <td>{{ $mes->nome_mes }} / {{ $mes->ano }}</td>
                                        <td>R$ {{ number_format($mes->salario, 2, ',', '.') }}</td>
                                        <td>R$ {{ number_format($mes->outros_valores, 2, ',', '.') }}</td>
                                        <td>
                                            <a href="{{ route('meses.mostrar', ['ano' => $mes->ano, 'mes' => $mes->mes]) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i> Ver
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Nenhum mês cadastrado ainda.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
