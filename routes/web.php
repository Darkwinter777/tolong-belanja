<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('/portal'));

// Single sign-in page for admins and customers; also the fallback target for guest redirects.
Route::redirect('/login', '/portal/login')->name('login');

require __DIR__.'/portal.php';
