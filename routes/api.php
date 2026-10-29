<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\RecetaController;
use App\Http\Controllers\Api\EtiquetaController;
use App\Http\Controllers\Api\LoginController;

Route::post('login', [LoginController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('categorias',CategoriaController::class);
    Route::apiResource('recetas',RecetaController::class);
    Route::apiResource('etiquetas',EtiquetaController::class);
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
