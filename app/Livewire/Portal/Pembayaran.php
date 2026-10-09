<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\Kost\Models\Pembayaran as KostPembayaran;
use Modules\Laundry\Models\Transaksi;

#[Layout('portal.layouts.app', ['showNav' => false, 'narrow' => true])]
class Pembayaran extends Component
{
    public string $metode = 'BCA Virtual Account';

    public bool $paid = false;

    public ?string $invoiceNo = null;

    public ?string $paidAt = null;

    protected function pelanggan()
    {
        return Auth::guard('pelanggan')->user();
    }

    public function getOutstandingPembayaransProperty()
    {
        $kontrakIds = $this->pelanggan()->penghunis()
            ->with('kontrakSewas')
            ->get()
            ->pluck('kontrakSewas')
            ->flatten()
            ->pluck('id');

        if ($kontrakIds->isEmpty()) {
            return collect();
        }

        return KostPembayaran::whereIn('kost_kontrak_sewa_id', $kontrakIds)
            ->whereIn('status', ['belum_lunas', 'telat'])
            ->with('kontrakSewa.kamar')
            ->get();
    }

    public function getOutstandingTransaksisProperty()
    {
        $orderIds = $this->pelanggan()->orders()->pluck('id');

        if ($orderIds->isEmpty()) {
            return collect();
        }

        return Transaksi::whereIn('laundry_order_id', $orderIds)
            ->where('status', 'belum_bayar')
            ->with('order.layanan')
            ->get();
    }

    public function getTotalProperty(): float
    {
        return $this->outstandingPembayarans->sum('jumlah_tagihan') + $this->outstandingTransaksis->sum('jumlah_bayar');
    }

    public function getJumlahTagihanProperty(): int
    {
        return $this->outstandingPembayarans->count() + $this->outstandingTransaksis->count();
    }

    public function pilihMetode(string $metode): void
    {
        $this->metode = $metode;
    }

    public function bayar(): void
    {
        DB::transaction(function () {
            foreach ($this->outstandingPembayarans as $tagihan) {
                $tagihan->update([
                    'status' => 'lunas',
                    'tanggal_bayar' => now(),
                    'metode_pembayaran' => $this->metode,
                ]);
            }

            foreach ($this->outstandingTransaksis as $transaksi) {
                $transaksi->update([
                    'status' => 'lunas',
                    'tanggal_bayar' => now(),
                    'metode_pembayaran' => $this->metode,
                ]);
            }
        });

        $this->invoiceNo = 'INV/'.now()->format('Y/m').'/'.str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        $this->paidAt = now()->translatedFormat('d M Y, H:i');
        $this->paid = true;
    }

    public function render()
    {
        return view('livewire.portal.pembayaran');
    }
}
