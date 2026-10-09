<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('portal.layouts.app', ['showNav' => false])]
class Notifikasi extends Component
{
    public function getNotificationsProperty()
    {
        return Auth::guard('pelanggan')->user()->notifications()->latest()->get();
    }

    public function markAllRead(): void
    {
        Auth::guard('pelanggan')->user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        return view('livewire.portal.notifikasi');
    }
}
