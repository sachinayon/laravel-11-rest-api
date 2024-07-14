<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['isApiKeyValidated'])->group(function () {
    Route::apiResource('books', BookController::class);
    Route::post('books/{id}/restore', [BookController::class, 'restore']);
});
