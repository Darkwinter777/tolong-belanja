<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('portal.layouts.app', ['showNav' => false])]
class Kost extends Component
{
    public function getKontrakSewasProperty()
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        return $pelanggan->penghunis()
            ->with(['kontrakSewas.kamar', 'kontrakSewas.pembayarans'])
            ->get()
            ->pluck('kontrakSewas')
            ->flatten()
            ->sortByDesc('created_at');
    }

    public function render()
    {
        return view('livewire.portal.kost');
    }
}
