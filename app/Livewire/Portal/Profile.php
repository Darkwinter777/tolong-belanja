<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('portal.layouts.app', ['narrow' => true])]
class Profile extends Component
{
    public string $nama = '';

    public string $email = '';

    public string $no_hp = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function mount(): void
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        $this->nama = $pelanggan->nama;
        $this->email = $pelanggan->email;
        $this->no_hp = $pelanggan->no_hp ?? '';
    }

    public function updateProfile(): void
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        $validated = $this->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('pelanggans', 'email')->ignore($pelanggan->id)],
            'no_hp' => ['nullable', 'string', 'max:20'],
        ]);

        $pelanggan->update($validated);

        $this->dispatch('profile-updated');
    }

    public function updatePassword(): void
    {
        $this->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::guard('pelanggan')->user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['password', 'password_confirmation']);
        $this->dispatch('password-updated');
    }

    public function logout(): void
    {
        Auth::guard('pelanggan')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        $this->redirectRoute('portal.login', navigate: true);
    }

    public function getPenghuniAktifProperty()
    {
        return Auth::guard('pelanggan')->user()
            ->penghunis()
            ->with(['kontrakSewas' => fn ($q) => $q->where('status', 'aktif')->with('kamar')])
            ->get()
            ->first(fn ($p) => $p->kontrakSewas->isNotEmpty());
    }

    public function render()
    {
        return view('livewire.portal.profile');
    }
}
