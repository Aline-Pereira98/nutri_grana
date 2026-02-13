<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\LancamentoController;
use App\Http\Controllers\MesController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/cadastro', [AuthController::class, 'mostrarCadastro'])->name('cadastro');
Route::post('/cadastro', [AuthController::class, 'cadastro'])->name('cadastro.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rotas Autenticadas
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Perfil
    Route::prefix('perfil')->name('perfil.')->group(function () {
        Route::get('/', [PerfilController::class, 'index'])->name('index');
        Route::post('/atualizar', [PerfilController::class, 'atualizar'])->name('atualizar');
        Route::post('/criar-objetivo', [PerfilController::class, 'criarObjetivo'])->name('criar-objetivo');
        Route::post('/criar-reserva-seguranca', [PerfilController::class, 'criarReservaSeguranca'])->name('criar-reserva-seguranca');
    });

    // Lançamentos
    Route::prefix('lancamentos')->name('lancamentos.')->group(function () {
        Route::get('/', [LancamentoController::class, 'index'])->name('index');
        Route::post('/criar', [LancamentoController::class, 'criar'])->name('criar');
        Route::put('/{id}', [LancamentoController::class, 'atualizar'])->name('atualizar');
        Route::delete('/{id}', [LancamentoController::class, 'deletar'])->name('deletar');
    });

    // Meses
    Route::prefix('meses')->name('meses.')->group(function () {
        Route::get('/', [MesController::class, 'index'])->name('index');
        Route::get('/{ano}/{mes}', [MesController::class, 'mostrar'])->name('mostrar');
        Route::put('/{id}', [MesController::class, 'atualizar'])->name('atualizar');
        Route::post('/{mesId}/adicionar-reserva', [MesController::class, 'adicionarReserva'])->name('adicionar-reserva');
    });

    // Categorias
    Route::prefix('categorias')->name('categorias.')->group(function () {
        Route::get('/', [CategoriaController::class, 'index'])->name('index');
        Route::post('/criar', [CategoriaController::class, 'criar'])->name('criar');
        Route::put('/{id}', [CategoriaController::class, 'atualizar'])->name('atualizar');
        Route::delete('/{id}', [CategoriaController::class, 'deletar'])->name('deletar');
    });
});
