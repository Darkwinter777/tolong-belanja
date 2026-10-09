<?php

use Illuminate\Support\Facades\Route;
use Modules\Laundry\Http\Controllers\LaundryController;
use Modules\Laundry\Http\Controllers\NotaController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('laundries', LaundryController::class)->names('laundry');
});

Route::middleware(['auth'])->get('/laundry/orders/{order}/nota', [NotaController::class, 'show'])
    ->name('laundry.nota');
