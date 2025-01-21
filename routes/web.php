<?php

use App\Http\Controllers\CorteCaja\CorteCajaController;
use App\Http\Controllers\OfficeController;
use App\Livewire\Control\Cajas\CajaBancoController;
use App\Livewire\Control\Cajas\CajaEfectivoController;
use App\Livewire\DashBoards\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([ 'auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('Caja-Efectivo', CajaEfectivoController::class)->name('caja.Efectivo');
    Route::get('Caja-Banco', CajaBancoController::class)->name('caja.Banco');

    Route::get('/generar-corte/{fecha}/{tipo}', [CorteCajaController::class, 'corte'])->name('generar.corte');
});
