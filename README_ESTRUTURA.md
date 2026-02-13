# Sistema de Controle Financeiro Pessoal

Sistema web de controle financeiro pessoal mensal desenvolvido com Laravel, PHP 7.4+, MySQL, Bootstrap e jQuery.

## Estrutura do Projeto

### Models
- `User` - Usuários do sistema
- `Mes` - Meses financeiros
- `Lancamento` - Lançamentos de despesas/receitas
- `Categoria` - Categorias de lançamentos
- `FormaPagamento` - Formas de pagamento
- `Objetivo` - Objetivos financeiros
- `ReservaSeguranca` - Reservas de segurança
- `ReservaMes` - Reservas por mês

### Repositories
Todos os repositories estão em `app/Repositories/`:
- `UserRepository`
- `MesRepository`
- `LancamentoRepository`
- `CategoriaRepository`
- `FormaPagamentoRepository`
- `ObjetivoRepository`
- `ReservaSegurancaRepository`
- `ReservaMesRepository`

### Services
Todos os services estão em `app/Services/`:
- `AuthService` - Autenticação e registro
- `LancamentoService` - Lógica de lançamentos (simples e parcelados)
- `MesService` - Lógica de meses e cálculos
- `CategoriaService` - Lógica de categorias
- `PerfilService` - Lógica de perfil, objetivos e reservas

### Controllers
Todos os controllers estão em `app/Http/Controllers/`:
- `AuthController` - Login e cadastro
- `HomeController` - Página inicial
- `PerfilController` - Gerenciamento de perfil
- `LancamentoController` - Gerenciamento de lançamentos
- `MesController` - Gerenciamento de meses
- `CategoriaController` - Gerenciamento de categorias

### Views (Blade)
- `layouts/app.blade.php` - Layout principal com sidebar
- `auth/login.blade.php` - Página de login
- `auth/cadastro.blade.php` - Página de cadastro
- `home.blade.php` - Dashboard inicial
- `perfil/index.blade.php` - Perfil do usuário
- `meses/index.blade.php` - Lista de meses
- `meses/mostrar.blade.php` - Detalhes do mês
- `lancamentos/index.blade.php` - Lista de lançamentos
- `categorias/index.blade.php` - Gerenciamento de categorias

## Instalação

1. Configure o arquivo `.env` com suas credenciais do banco de dados
2. Execute as migrations:
```bash
php artisan migrate
```
3. Execute o seeder para criar as formas de pagamento padrão:
```bash
php artisan db:seed --class=FormaPagamentoSeeder
```

## Funcionalidades

### Autenticação
- Login com email e senha
- Cadastro com validação de senha forte
- Campos: nome, email, data de nascimento, profissão, motivo do controle financeiro

### Meses
- Criação automática de meses ao acessar
- Cadastro de salário e outros valores
- Visualização de lançamentos do mês
- Cálculo automático de totais (entradas, saídas, reservas, restante)

### Lançamentos
- Lançamento simples
- Lançamento parcelado (cria automaticamente nos meses subsequentes)
- Campos: descrição, valor, categoria, forma de pagamento, datas, essencial
- Deletar lançamento (e suas parcelas se for parcelado)

### Categorias
- Criar categorias personalizadas
- Usar categorias nos lançamentos

### Perfil
- Editar dados pessoais
- Criar objetivos financeiros
- Criar reservas de segurança
- Visualizar progresso dos objetivos e reservas

## Rotas Principais

- `/` - Redireciona para home
- `/login` - Página de login
- `/cadastro` - Página de cadastro
- `/home` - Dashboard (requer autenticação)
- `/perfil` - Perfil do usuário (requer autenticação)
- `/lancamentos` - Lista de lançamentos (requer autenticação)
- `/meses` - Lista de meses (requer autenticação)
- `/meses/{ano}/{mes}` - Detalhes do mês (requer autenticação)
- `/categorias` - Gerenciamento de categorias (requer autenticação)

## Observações

- O sistema usa middleware `auth` para proteger rotas autenticadas
- As senhas são hasheadas automaticamente pelo Laravel
- Os lançamentos parcelados são criados automaticamente nos meses subsequentes
- As reservas são calculadas automaticamente e atualizam os objetivos/reservas de segurança
