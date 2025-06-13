<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productoController;
use App\Http\Controllers\ventaController;
use App\Http\Controllers\itemsController;
use App\Http\Controllers\UserController;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'mensaje' => 'required|string',
    ]);
    Mail::to('spamlulomail@gmail.com')->send(new ContactFormMail($validated));

    return response()->json(['message' => 'Email sent successfully.']);
});


//rutas user
Route::post('/register', [userController::class, 'register']);
Route::post('/login', [userController::class, 'login']);
Route::delete('/logout/{id}', [userController::class, 'logout']);

Route::get('/user', [userController::class, 'index']);
Route::get('/user/{id}', [userController::class, 'show']);
Route::post('/user', [userController::class, 'store']);
Route::put('/user/{id}', [userController::class, 'update']);
Route::delete('/user/{id}', [userController::class, 'destroy']);

//rutas Producto
Route::get('/producto', [productoController::class, 'index']);
Route::get('/producto/{id}', [productoController::class, 'show']);
Route::post('/producto', [productoController::class, 'store']);
Route::put('/producto/{id}', [productoController::class, 'update']);
Route::put('/producto/partial/{id}', [productoController::class, 'updatePartial']);
Route::delete('/producto/{id}', [productoController::class, 'destroy']);

//rutas Venta
Route::get('/venta', [ventaController::class, 'index']);
Route::get('/venta/{id}', [ventaController::class, 'show']);
Route::post('/venta', [ventaController::class, 'store']);
Route::put('/venta/{id}', [ventaController::class, 'update']);
Route::patch('/venta/{id}', [ventaController::class, 'updatePartial']);
Route::delete('/venta/{id}', [ventaController::class, 'destroy']);

//rutas items
Route::get('/items', [itemsController::class, 'index']);
Route::get('/items/{id}', [itemsController::class, 'show']);
Route::post('/items', [itemsController::class, 'store']);
Route::put('/items/{id}', [itemsController::class, 'update']);
Route::patch('/items/{id}', [itemsController::class, 'updatePartial']);
Route::delete('/items/{id}', [itemsController::class, 'destroy']);

//rutas Reviews
Route::get('/review', [reviewController::class, 'index']);
Route::get('/review/{id}', [reviewController::class, 'show']);
Route::post('/review', [reviewController::class, 'store']);
Route::delete('/review/{id}', [reviewController::class, 'destroy']);


/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 */

 /**
  * fondos claros en ambas paginas
  * teniendo encuneta colores del logo
  *reporte productos reseñados

  */
