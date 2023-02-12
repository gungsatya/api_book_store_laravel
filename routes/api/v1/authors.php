<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;

Route::prefix('authors')
    ->as('authors.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/', [AuthorController::class, 'index'])
            ->name('index');

        Route::post('/', [AuthorController::class, 'store'])
            ->name('store');

        Route::get('/{author}', [AuthorController::class, 'show'])
            ->whereNumber(['author'])
            ->name('show');

        Route::patch('/{author}', [AuthorController::class, 'update'])
            ->whereNumber(['author'])
            ->name('update');
        
        Route::delete('/{author}', [AuthorController::class, 'destroy'])
            ->whereNumber(['author'])
            ->name('destroy');
    });
