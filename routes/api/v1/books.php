<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::prefix('books')
    ->as('books.')
    ->group(function () {
        Route::get('/', [BookController::class, 'index'])
            ->name('index');

        Route::post('/', [BookController::class, 'store'])
            ->name('store');

        Route::get('/{book}', [BookController::class, 'show'])
            ->whereNumber(['book'])
            ->name('show');

        Route::put('/{book}', [BookController::class, 'update'])
            ->whereNumber(['book'])
            ->name('update');

        Route::delete('/{book}', [BookController::class, 'destroy'])
            ->whereNumber(['book'])
            ->name('destroy');
    });
