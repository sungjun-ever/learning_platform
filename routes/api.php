<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('users')->middleware('auth:sanctum')->group(function () {
    Route::get('/{uuid}', [UserController::class, 'show'])
        ->whereUuid('uuid');

    Route::post('/', [UserController::class, 'store'])->withoutMiddleware('auth:sanctum');

    Route::put('/{uuid}', [UserController::class, 'update'])
        ->whereUuid('uuid');

    Route::delete('/{uuid}', [UserController::class, 'destroy'])
        ->whereUuid('uuid');
});
