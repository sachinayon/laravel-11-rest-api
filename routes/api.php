<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ApiKeyController;

// Authentication routes routes
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    Route::get('/me', [AuthController::class, 'me'])->name('me');
});

Route::middleware(['isApiKeyValidated'])->group(function () {
    // Book management routes
    Route::apiResource('books', BookController::class);
    Route::post('books/{id}/restore', [BookController::class, 'restore']); // Restore deleted books

    // API Key management routes
    Route::apiResource('api-keys', ApiKeyController::class);
    Route::patch('api-keys/{id}/activate', [ApiKeyController::class, 'activate']); // Activate API key
    Route::patch('api-keys/{id}/deactivate', [ApiKeyController::class, 'deactivate']); // Deactivate API key
});
