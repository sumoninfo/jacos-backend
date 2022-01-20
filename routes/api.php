<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Resources\AuthUserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API Routes
Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::post('/register', [ApiAuthController::class, 'register']);
    //---------Admin Routing----------
    Route::middleware(['auth:api'])->group(function () {
        Route::get('/user', function (Request $request) {
            return new AuthUserResource($request->user());
        });
        Route::post('/logout', [ApiAuthController::class, 'logout']);
    });
});
