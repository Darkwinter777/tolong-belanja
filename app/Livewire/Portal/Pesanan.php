<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('portal.layouts.app')]
class Pesanan extends Component
{
    public function getKontrakSewasProperty(): Collection
    {
        return Auth::guard('pelanggan')->user()
            ->penghunis()
            ->with('kontrakSewas.kamar')
            ->get()
            ->pluck('kontrakSewas')
            ->flatten();
    }

    public function getActiveLanggananProperty()
    {
        return $this->kontrakSewas->firstWhere('status', 'aktif');
    }

    public function getItemsProperty(): Collection
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        $kontrakItems = $this->kontrakSewas
            ->reject(fn ($kontrak) => $this->activeLangganan && $kontrak->id === $this->activeLangganan->id)
            ->map(fn ($kontrak) => [
                'type' => 'kost',
                'icon' => 'heroicon-s-home-modern',
                'title' => 'Kamar '.($kontrak->kamar?->nomor_kamar ?? '-'),
                'subtitle' => 'Sewa Rp '.number_format($kontrak->harga_bulanan, 0, ',', '.').' / bulan',
                'status' => $kontrak->status,
                'date' => $kontrak->created_at,
                'url' => route('portal.kost'),
            ]);

        $orderItems = $pelanggan->orders()
            ->with('layanan')
            ->get()
            ->map(fn ($order) => [
                'type' => 'laundry',
                'icon' => 'heroicon-s-sparkles',
                'title' => $order->kode_order,
                'subtitle' => $order->layanan?->nama_layanan ?? '-',
                'status' => $order->status,
                'date' => $order->created_at,
                'url' => route('portal.laundry.detail', $order->id),
            ]);

        return $kontrakItems->concat($orderItems)->sortByDesc('date')->values();
    }

    public function render()
    {
        return view('livewire.portal.pesanan');
    }
}
