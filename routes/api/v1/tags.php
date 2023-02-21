<?php

use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::prefix('tags')
    ->as('tags.')
    ->group(function () {
        Route::get('/', [TagController::class, 'index'])
            ->name('index');

        Route::post('/', [TagController::class, 'store'])
            ->name('store');

        Route::delete('/{tag}', [TagController::class, 'destroy'])
            ->whereNumber(['tag'])
            ->name('destroy');
    });
