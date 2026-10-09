<?php

use Illuminate\Support\Facades\Route;
use Modules\Kost\Http\Controllers\KostController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('kosts', KostController::class)->names('kost');
});
