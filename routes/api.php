<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);

    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books', [BookController::class, 'store']);

    Route::put('/books/{book}', [BookController::class, 'update']);

    Route::delete('/books/{book}', [BookController::class, 'destroy']);
});