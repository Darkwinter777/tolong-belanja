<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('/portal'));

require __DIR__.'/portal.php';
