<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Controle Financeiro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100 py-5">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-person-plus" style="font-size: 3rem; color: #28a745;"></i>
                            <h2 class="mt-3">Criar Conta</h2>
                            <p class="text-muted">Preencha os dados para se cadastrar</p>
                        </div>

                        <form method="POST" action="{{ route('cadastro') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="nome" class="form-label">Nome Completo</label>
                                    <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                                           id="nome" name="nome" value="{{ old('nome') }}" required>
                                    @error('nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                                    <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror" 
                                           id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento') }}" required>
                                    @error('data_nascimento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Senha</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Mínimo de 8 caracteres</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="profissao" class="form-label">Profissão</label>
                                <input type="text" class="form-control @error('profissao') is-invalid @enderror" 
                                       id="profissao" name="profissao" value="{{ old('profissao') }}">
                                @error('profissao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="motivo_controle_financeiro" class="form-label">Por que deseja fazer o controle financeiro?</label>
                                <select class="form-select @error('motivo_controle_financeiro') is-invalid @enderror" 
                                        id="motivo_controle_financeiro" name="motivo_controle_financeiro">
                                    <option value="">Selecione uma opção</option>
                                    <option value="Organizar gastos" {{ old('motivo_controle_financeiro') == 'Organizar gastos' ? 'selected' : '' }}>Organizar gastos</option>
                                    <option value="Economizar dinheiro" {{ old('motivo_controle_financeiro') == 'Economizar dinheiro' ? 'selected' : '' }}>Economizar dinheiro</option>
                                    <option value="Alcançar objetivos" {{ old('motivo_controle_financeiro') == 'Alcançar objetivos' ? 'selected' : '' }}>Alcançar objetivos</option>
                                    <option value="Controlar dívidas" {{ old('motivo_controle_financeiro') == 'Controlar dívidas' ? 'selected' : '' }}>Controlar dívidas</option>
                                    <option value="Planejamento futuro" {{ old('motivo_controle_financeiro') == 'Planejamento futuro' ? 'selected' : '' }}>Planejamento futuro</option>
                                    <option value="Outro" {{ old('motivo_controle_financeiro') == 'Outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                                @error('motivo_controle_financeiro')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success w-100 mb-3">
                                <i class="bi bi-person-check"></i> Cadastrar
                            </button>

                            <div class="text-center">
                                <p class="mb-0">Já tem uma conta? 
                                    <a href="{{ route('login') }}">Faça login</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
