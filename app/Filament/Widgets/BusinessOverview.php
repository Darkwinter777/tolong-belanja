<?php

namespace App\Filament\Widgets;

use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;
use Modules\Kost\Models\Kamar;
use Modules\Kost\Models\Pembayaran;
use Modules\Laundry\Models\Order;
use Modules\Laundry\Models\Transaksi;

class BusinessOverview extends StatsOverviewWidget
{
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $stats = [];
        $user = auth()->user();

        if ($user?->can('access kost')) {
            $kamarTerisi = Kamar::where('status', 'terisi')->count();
            $kamarKosong = Kamar::where('status', 'kosong')->count();

            $pendapatanBulanIni = Pembayaran::where('status', 'lunas')
                ->whereMonth('tanggal_bayar', now()->month)
                ->whereYear('tanggal_bayar', now()->year)
                ->sum('jumlah_tagihan');

            $tagihanBelumLunas = Pembayaran::whereIn('status', ['belum_lunas', 'telat'])->count();

            $stats[] = Stat::make('Kamar Terisi / Kosong', "{$kamarTerisi} / {$kamarKosong}")
                ->icon(Heroicon::OutlinedHome)
                ->color('info');

            $stats[] = Stat::make('Pendapatan Kost Bulan Ini', 'Rp '.Number::format($pendapatanBulanIni, 0))
                ->icon(Heroicon::OutlinedBanknotes)
                ->color('success');

            $stats[] = Stat::make('Tagihan Belum Lunas', (string) $tagihanBelumLunas)
                ->icon(Heroicon::OutlinedExclamationTriangle)
                ->color($tagihanBelumLunas > 0 ? 'danger' : 'success');
        }

        if ($user?->can('access laundry')) {
            $orderAktif = Order::whereIn('status', ['diterima', 'proses'])->count();

            $pendapatanHarian = Transaksi::where('status', 'lunas')
                ->whereDate('tanggal_bayar', today())
                ->sum('jumlah_bayar');

            $pendapatanBulanan = Transaksi::where('status', 'lunas')
                ->whereMonth('tanggal_bayar', now()->month)
                ->whereYear('tanggal_bayar', now()->year)
                ->sum('jumlah_bayar');

            $stats[] = Stat::make('Order Laundry Aktif', (string) $orderAktif)
                ->icon(Heroicon::OutlinedShoppingBag)
                ->color('warning');

            $stats[] = Stat::make('Pendapatan Laundry Hari Ini', 'Rp '.Number::format($pendapatanHarian, 0))
                ->icon(Heroicon::OutlinedCurrencyDollar)
                ->color('success');

            $stats[] = Stat::make('Pendapatan Laundry Bulan Ini', 'Rp '.Number::format($pendapatanBulanan, 0))
                ->icon(Heroicon::OutlinedCurrencyDollar)
                ->color('success');
        }

        return $stats;
    }
}
