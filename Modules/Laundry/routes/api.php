<?php

use Illuminate\Support\Facades\Route;
use Modules\Laundry\Http\Controllers\LaundryController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('laundries', LaundryController::class)->names('laundry');
});
