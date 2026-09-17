<?php

use App\Http\Controllers\VeiculoController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/veiculos');

Route::resource('veiculos', VeiculoController::class)
    ->except('show')
    ->parameters(['veiculos' => 'veiculo']);

// RNF-03: permite à pipeline (e ao professor) conferir a versão publicada
Route::get('/versao', fn () => response()->json([
    'aplicacao' => config('app.name'),
    'versao' => config('sistema.versao'),
]))->name('versao');
