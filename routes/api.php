<?php

use App\Helpers\Routes\RouteHelper;
use App\Http\Controllers\ApiAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')
    ->middleware([
        'auth:sanctum'
    ])
    ->group(function () {
        RouteHelper::includeRouteFiles(__DIR__ . '/api/v1');
    });

Route::prefix('auth')
    ->as('auth.')
    ->group(function () {
        Route::post('register', [ApiAuthController::class, 'register'])
            ->name('register');

        Route::post('login', [ApiAuthController::class, 'login'])
            ->name('login');

        Route::post('refresh-token', [ApiAuthController::class, 'refreshToken'])
            ->middleware('auth:sanctum')
            ->name('refreshToken');

        Route::post('logout', [ApiAuthController::class, 'logout'])
            ->middleware('auth:sanctum')
            ->name('logout');

        Route::get('user/profile', [ApiAuthController::class, 'showProfileInformation'])
            ->middleware('auth:sanctum')
            ->name('showProfileInformation');

        Route::put('user/profile', [ApiAuthController::class, 'updateProfileInformation'])
            ->middleware('auth:sanctum')
            ->name('updateProfileInformation');
    });
