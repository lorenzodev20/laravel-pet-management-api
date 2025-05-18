<?php


use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware(['jwt.verify'])->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login')->withoutMiddleware(['jwt.verify']);
        Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
        Route::post('me', [\App\Http\Controllers\AuthController::class, 'me']);
        Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
        Route::post('register', [\App\Http\Controllers\AuthController::class, 'register'])->withoutMiddleware(['jwt.verify']);
    });

    Route::get('person/{person}/with-pets', [\App\Http\Controllers\Api\V1\Person\PersonWithPetsController::class, 'index']);
    Route::apiResource('person', App\Http\Controllers\Api\V1\Person\PersonController::class);
    Route::apiResource('pet', App\Http\Controllers\Api\V1\Pet\PetController::class);
    Route::get('pet/cat/breeds', [\App\Http\Controllers\Api\V1\Pet\CatController::class, 'breeds']);

});
