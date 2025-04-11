<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\registroController;
use App\Http\Controllers\productoController;

//rutas Registro
Route::get('/registro', [registroController::class, 'index']);
Route::get('/registro/{id}', [registroController::class, 'show']);
Route::post('/registro', [registroController::class, 'store']);
Route::put('/registro/{id}', [registroController::class, 'update']);
Route::delete('/registro/{id}', [registroController::class, 'destroy']);

//rutas Producto
Route::get('/producto', [productoController::class, 'index']);
Route::get('/producto/{id}', [productoController::class, 'show']);
Route::post('/producto', [productoController::class, 'store']);
Route::put('/producto/{id}', [productoController::class, 'update']);
Route::delete('/producto/{id}', [productoController::class, 'destroy']);

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 */