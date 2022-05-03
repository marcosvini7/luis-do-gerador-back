<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('produtos', \App\Http\Controllers\ProdutoController::class);
Route::apiResource('contato', \App\Http\Controllers\ContatoController::class);
Route::apiResource('informacoes', \App\Http\Controllers\InformacaoController::class);
Route::apiResource('servicos', \App\Http\Controllers\ServicoController::class);
Route::post('users', [\App\Http\Controllers\UserController::class, 'login']);
