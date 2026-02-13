@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <span class="text-muted">{{ date('d/m/Y') }}</span>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Olá, {{ $usuario->nome }}!</h5>
                <p class="card-text">Pequenas ações geram grandes resultados.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Meses</h5>
                <p class="card-text">Gerencie seus meses financeiros</p>
                <a href="{{ route('meses.index') }}" class="btn btn-primary">
                    <i class="bi bi-calendar-month"></i> Ver Meses
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Lançamentos</h5>
                <p class="card-text">Visualize todos os seus lançamentos</p>
                <a href="{{ route('lancamentos.index') }}" class="btn btn-primary">
                    <i class="bi bi-receipt"></i> Ver Lançamentos
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Categorias</h5>
                <p class="card-text">Gerencie suas categorias</p>
                <a href="{{ route('categorias.index') }}" class="btn btn-primary">
                    <i class="bi bi-tags"></i> Ver Categorias
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
