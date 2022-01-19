<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', 'UsersController@login');
    Route::post('/register', 'UsersController@register');
    Route::get('/logout', 'UsersController@logout')->middleware('auth:api');
});
*/

// API Routes
Route::group(['prefix' => 'v1'], function () { 
    Route::post('/login', [\App\Http\Controllers\ApiAuthController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\ApiAuthController::class, 'register']);
    //---------Admin Routing----------
    Route::middleware(['auth:api'])->group(function () {
        Route::get('/user', function (Request $request) {
            return new \App\Http\Resources\AuthUserResource($request->user());
        });
        Route::post('/logout', [\App\Http\Controllers\ApiAuthController::class, 'logout']);
        //dashboard
        Route::get('/dashboard/data', [\App\Http\Controllers\DashboardController::class, 'getDashboardData']);
    });
});
