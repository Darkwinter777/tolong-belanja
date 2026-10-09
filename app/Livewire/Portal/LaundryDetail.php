<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\Laundry\Models\Order;

#[Layout('portal.layouts.app', ['showNav' => false, 'narrow' => true])]
class LaundryDetail extends Component
{
    public Order $order;

    public function mount(Order $order): void
    {
        abort_unless($order->pelanggan_id === Auth::guard('pelanggan')->id(), 403);

        $this->order = $order->load('layanan', 'transaksis');
    }

    public function getTimelineProperty(): array
    {
        $steps = ['diterima' => 'Pesanan dibuat', 'dijemput' => 'Dijemput kurir', 'proses' => 'Sedang dicuci', 'diambil' => 'Siap diantar'];

        $order = ['diterima', 'dijemput', 'proses', 'diambil'];
        $statusToIndex = match ($this->order->status) {
            'diterima' => 0,
            'proses' => 2,
            'selesai' => 3,
            'diambil' => 3,
            default => 0,
        };

        return collect($order)->values()->map(function (string $key, int $i) use ($steps, $statusToIndex) {
            return [
                'label' => $steps[$key],
                'done' => $i < $statusToIndex || ($this->order->status === 'diambil' && $i <= $statusToIndex),
                'current' => $i === $statusToIndex && $this->order->status !== 'diambil',
            ];
        })->toArray();
    }

    public function getSudahLunasProperty(): bool
    {
        return $this->order->transaksis->contains('status', 'lunas');
    }

    public function render()
    {
        return view('livewire.portal.laundry-detail');
    }
}
