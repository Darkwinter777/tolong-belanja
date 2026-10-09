<?php

use Illuminate\Support\Facades\Route;
use Modules\Kost\Http\Controllers\KostController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('kosts', KostController::class)->names('kost');
});
