<?php

use App\Http\Controllers\Portal\InvoiceController;
use App\Livewire\Portal\Home;
use App\Livewire\Portal\Kost;
use App\Livewire\Portal\KostBooking;
use App\Livewire\Portal\Laundry;
use App\Livewire\Portal\LaundryBooking;
use App\Livewire\Portal\LaundryDetail;
use App\Livewire\Portal\Login;
use App\Livewire\Portal\Notifikasi;
use App\Livewire\Portal\Pembayaran;
use App\Livewire\Portal\Pesanan;
use App\Livewire\Portal\Profile;
use App\Livewire\Portal\Register;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:pelanggan')->group(function () {
    Route::get('/portal/login', Login::class)->name('portal.login');
    Route::get('/portal/register', Register::class)->name('portal.register');
});

Route::middleware('auth:pelanggan')->group(function () {
    Route::get('/portal', Home::class)->name('portal.home');
    Route::get('/portal/pesanan', Pesanan::class)->name('portal.pesanan');
    Route::get('/portal/kost', Kost::class)->name('portal.kost');
    Route::get('/portal/kost/booking', KostBooking::class)->name('portal.kost.book');
    Route::get('/portal/laundry', Laundry::class)->name('portal.laundry');
    Route::get('/portal/laundry/booking', LaundryBooking::class)->name('portal.laundry.book');
    Route::get('/portal/laundry/{order}', LaundryDetail::class)->name('portal.laundry.detail');
    Route::get('/portal/notifikasi', Notifikasi::class)->name('portal.notifikasi');
    Route::get('/portal/pembayaran', Pembayaran::class)->name('portal.pembayaran');
    Route::get('/portal/invoice', [InvoiceController::class, 'show'])->name('portal.invoice');
    Route::get('/portal/profile', Profile::class)->name('portal.profile');
});
