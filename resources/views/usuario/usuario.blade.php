@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Perfil</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Dados Pessoais</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('perfil.atualizar') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" 
                               value="{{ old('nome', $usuario->nome) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email', $usuario->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" 
                               value="{{ old('data_nascimento', $usuario->data_nascimento->format('Y-m-d')) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="profissao" class="form-label">Profissão</label>
                        <input type="text" class="form-control" id="profissao" name="profissao" 
                               value="{{ old('profissao', $usuario->profissao) }}">
                    </div>

                    <div class="mb-3">
                        <label for="motivo_controle_financeiro" class="form-label">Motivo do Controle Financeiro</label>
                        <input type="text" class="form-control" id="motivo_controle_financeiro" name="motivo_controle_financeiro" 
                               value="{{ old('motivo_controle_financeiro', $usuario->motivo_controle_financeiro) }}">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Nova Senha (deixe em branco para não alterar)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>

                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Objetivos</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('perfil.criar-objetivo') }}" class="mb-3">
                    @csrf
                    <div class="mb-2">
                        <input type="text" class="form-control" name="nome" placeholder="Nome do objetivo" required>
                    </div>
                    <div class="mb-2">
                        <input type="number" step="0.01" class="form-control" name="valor_objetivo" placeholder="Valor objetivo" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Adicionar Objetivo</button>
                </form>

                <ul class="list-group">
                    @forelse($objetivos as $objetivo)
                        <li class="list-group-item">
                            <strong>{{ $objetivo->nome }}</strong><br>
                            <small>R$ {{ number_format($objetivo->valor_atual, 2, ',', '.') }} / R$ {{ number_format($objetivo->valor_objetivo, 2, ',', '.') }}</small>
                            <br>
                            <small class="text-muted">Faltante: R$ {{ number_format($objetivo->valor_faltante, 2, ',', '.') }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Nenhum objetivo cadastrado</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Reservas de Segurança</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('perfil.criar-reserva-seguranca') }}" class="mb-3">
                    @csrf
                    <div class="mb-2">
                        <input type="text" class="form-control" name="nome" placeholder="Nome da reserva" required>
                    </div>
                    <div class="mb-2">
                        <input type="number" step="0.01" class="form-control" name="valor_objetivo" placeholder="Valor objetivo" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Adicionar Reserva</button>
                </form>

                <ul class="list-group">
                    @forelse($reservasSeguranca as $reserva)
                        <li class="list-group-item">
                            <strong>{{ $reserva->nome }}</strong><br>
                            <small>R$ {{ number_format($reserva->valor_atual, 2, ',', '.') }} / R$ {{ number_format($reserva->valor_objetivo, 2, ',', '.') }}</small>
                            <br>
                            <small class="text-muted">Faltante: R$ {{ number_format($reserva->valor_faltante, 2, ',', '.') }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Nenhuma reserva cadastrada</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
