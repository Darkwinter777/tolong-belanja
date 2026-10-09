<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\Kost\Models\Kamar;

#[Layout('portal.layouts.app')]
class Home extends Component
{
    public function getPelangganProperty()
    {
        return Auth::guard('pelanggan')->user();
    }

    public function getKamarKosongCountProperty()
    {
        return Kamar::where('status', 'kosong')->count();
    }

    public function getKamarTermurahProperty()
    {
        return Kamar::where('status', 'kosong')->orderBy('harga')->first();
    }

    public function getCurrentOrderProperty()
    {
        $order = $this->pelanggan->orders()
            ->with('layanan')
            ->whereIn('status', ['diterima', 'proses'])
            ->latest()
            ->first();

        if (! $order) {
            return null;
        }

        $progress = match ($order->status) {
            'diterima' => 20,
            'proses' => 60,
            default => 90,
        };

        return [
            'order' => $order,
            'progress' => $progress,
        ];
    }

    public function render()
    {
        return view('livewire.portal.home');
    }
}
