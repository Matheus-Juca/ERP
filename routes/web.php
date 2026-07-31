<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovimentacaoController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\OrdemServicoController;
use App\Http\Controllers\EstoqueController;




Route::get('/', function () {
    return view('welcome');
});

route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/financeiro', [MovimentacaoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard-fin');

Route::post('/movimentacoes', [MovimentacaoController::class, 'store'])
    ->name('movimentacoes.store');

Route::get('/servicos', [ServicoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('servicos');

Route::post('/servicos', [ServicoController::class, 'store'])
    ->name('servicos.store');

Route::post('/ordens', [OrdemServicoController::class, 'store'])
    ->name('ordens.store');

Route::get('/estoque', [Estoquecontroller::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('estoque');    

Route::post('/estoques', [Estoquecontroller::class, 'store'])
    ->name('estoque.store');    
    

require __DIR__.'/auth.php';
