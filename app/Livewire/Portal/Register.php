<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\Core\Models\Pelanggan;

#[Layout('portal.layouts.app', ['narrow' => true])]
class Register extends Component
{
    public string $nama = '';

    public string $email = '';

    public string $no_hp = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('pelanggans', 'email')],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::guard('pelanggan')->login($pelanggan);

        request()->session()->regenerate();

        $this->redirectRoute('portal.home', navigate: true);
    }

    public function render()
    {
        return view('livewire.portal.register');
    }
}
