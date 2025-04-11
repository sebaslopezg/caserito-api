<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\registroController;
use App\Http\Controllers\productoController;
use App\Http\Controllers\ventaController;

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
Route::patch('/producto/{id}', [productoController::class, 'updatePartial']);
Route::delete('/producto/{id}', [productoController::class, 'destroy']);

//rutas Venta
Route::get('/venta', [ventaController::class, 'index']);
Route::get('/venta/{id}', [ventaController::class, 'show']);
Route::post('/venta', [ventaController::class, 'store']);
Route::put('/venta/{id}', [ventaController::class, 'update']);
Route::patch('/venta/{id}', [ventaController::class, 'updatePartial']);
Route::delete('/venta/{id}', [ventaController::class, 'destroy']);

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 */