<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\registroController;

Route::get('/registro', [registroController::class, 'index']);
Route::get('/registro/{id}', [registroController::class, 'show']);
Route::post('/registro', [registroController::class, 'store']);
Route::put('/registro/{id}', [registroController::class, 'update']);
Route::delete('/registro/{id}', [registroController::class, 'destroy']);

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 */