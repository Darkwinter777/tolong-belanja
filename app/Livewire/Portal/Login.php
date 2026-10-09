<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\Core\Models\Pelanggan;

#[Layout('portal.layouts.app')]
class Login extends Component
{
    public string $phone = '';

    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate([
            'phone' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $normalizedPhone = '0'.ltrim(preg_replace('/\D/', '', $this->phone), '0');

        $pelanggan = Pelanggan::where('no_hp', $normalizedPhone)
            ->orWhere('email', $this->phone)
            ->first();

        if (! $pelanggan || ! Hash::check($this->password, $pelanggan->password)) {
            $this->addError('phone', 'No. HP atau password salah.');

            return;
        }

        Auth::guard('pelanggan')->login($pelanggan, $this->remember);

        request()->session()->regenerate();

        $this->redirectRoute('portal.home', navigate: true);
    }

    public function comingSoon(): void
    {
        $this->dispatch('coming-soon');
    }

    public function render()
    {
        return view('livewire.portal.login');
    }
}
