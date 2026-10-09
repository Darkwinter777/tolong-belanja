<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\Laundry\Models\Layanan;
use Modules\Laundry\Models\Order;
use Modules\Laundry\Models\Transaksi;

#[Layout('portal.layouts.app', ['showNav' => false, 'narrow' => true])]
class LaundryBooking extends Component
{
    public int $step = 1;

    public ?int $layananId = null;

    public float $jumlah = 3;

    public int $slotIdx = 1;

    public string $catatan = '';

    public function mount(): void
    {
        $this->layananId = Layanan::where('aktif', true)->orderBy('harga')->first()?->id;

        // Returning from sign-in: restore the choices made before the login gate.
        if (Auth::guard('pelanggan')->check() && $pending = session()->pull('portal.pending_booking.laundry')) {
            $this->layananId = $pending['layananId'];
            $this->jumlah = $pending['jumlah'];
            $this->slotIdx = $pending['slotIdx'];
            $this->catatan = $pending['catatan'];
            $this->step = 3;
        }
    }

    public function getLayanansProperty()
    {
        return Layanan::where('aktif', true)->orderBy('harga')->get();
    }

    public function getLayananProperty(): ?Layanan
    {
        return Layanan::find($this->layananId);
    }

    public function getSlotsProperty(): array
    {
        return [
            ['label' => 'Hari ini, 15.00', 'at' => today()->setTime(15, 0)],
            ['label' => 'Besok, 09.00', 'at' => today()->addDay()->setTime(9, 0)],
            ['label' => 'Besok, 15.00', 'at' => today()->addDay()->setTime(15, 0)],
        ];
    }

    public function getEstimasiSelesaiProperty()
    {
        return $this->slots[$this->slotIdx]['at']->copy()->addDays(2);
    }

    public function getTotalProperty(): float
    {
        return round(($this->layanan?->harga ?? 0) * $this->jumlah);
    }

    public function pilihLayanan(int $id): void
    {
        $this->layananId = $id;
    }

    public function tambahJumlah(): void
    {
        $this->jumlah = min(50, $this->jumlah + 0.5);
    }

    public function kurangiJumlah(): void
    {
        $this->jumlah = max(0.5, $this->jumlah - 0.5);
    }

    public function nextStep(): void
    {
        $this->step = min(3, $this->step + 1);
    }

    public function prevStep(): void
    {
        $this->step = max(1, $this->step - 1);
    }

    public function submit(): void
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        if (! $pelanggan) {
            session()->put('portal.pending_booking.laundry', [
                'layananId' => $this->layananId,
                'jumlah' => $this->jumlah,
                'slotIdx' => $this->slotIdx,
                'catatan' => $this->catatan,
            ]);
            session()->put('url.intended', route('portal.laundry.book'));

            $this->redirectRoute('portal.login', navigate: true);

            return;
        }

        $order = Order::create([
            'pelanggan_id' => $pelanggan->id,
            'nama_pelanggan' => $pelanggan->nama,
            'no_hp_pelanggan' => $pelanggan->no_hp,
            'laundry_layanan_id' => $this->layananId,
            'berat_atau_jumlah' => $this->jumlah,
            'total_harga' => $this->total,
            'estimasi_selesai' => $this->estimasiSelesai,
            'status' => 'diterima',
            'catatan' => $this->catatan ?: null,
        ]);

        Transaksi::create([
            'laundry_order_id' => $order->id,
            'jumlah_bayar' => $order->total_harga,
            'status' => 'belum_bayar',
        ]);

        $this->redirectRoute('portal.pembayaran', navigate: true);
    }

    public function render()
    {
        return view('livewire.portal.laundry-booking');
    }
}
