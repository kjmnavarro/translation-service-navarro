<?php

use App\Http\Controllers\TranslationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('translations/export', [TranslationController::class, 'export']);
    Route::get('translations/search', [TranslationController::class, 'index']);

    Route::apiResource('translations', TranslationController::class);
});

Route::get('/test-api-route', function () {
    return response()->json(['message' => 'API route is working']);
});