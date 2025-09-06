<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivrosController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/criarLivro', [LivrosController::class, 'store']);
Route::get('/livros', [LivrosController::class, 'index']);
Route::get('/livro/{id}', [LivrosController::class, 'show']);
Route::put('/upLivro/{id}', [LivrosController::class, 'update']);
Route::delete('/delLivro/{id}', [LivrosController::class, 'destroy']);