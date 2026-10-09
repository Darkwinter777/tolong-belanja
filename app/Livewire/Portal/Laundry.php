<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('portal.layouts.app', ['showNav' => false])]
class Laundry extends Component
{
    public function getOrdersProperty()
    {
        return Auth::guard('pelanggan')->user()
            ->orders()
            ->with('layanan')
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.portal.laundry');
    }
}
