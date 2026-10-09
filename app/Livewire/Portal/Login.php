<?php

namespace App\Livewire\Portal;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\Core\Models\Pelanggan;

#[Layout('portal.layouts.app', ['narrow' => true])]
class Login extends Component
{
    public string $identifier = '';

    public string $password = '';

    public bool $remember = false;

    public function mount(): void
    {
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->canAccessPanel(Filament::getPanel('admin'))) {
            $this->redirect(url('/admin'));
        }
    }

    public function login(): void
    {
        $this->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $identifier = trim($this->identifier);
        $throttleKey = 'portal-login:'.strtolower($identifier).'|'.request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('identifier', "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.");

            return;
        }

        // Admin / staff: identified by email.
        if (str_contains($identifier, '@')) {
            $user = User::where('email', $identifier)->first();

            if ($user
                && Hash::check($this->password, $user->password)
                && $user->canAccessPanel(Filament::getPanel('admin'))
            ) {
                RateLimiter::clear($throttleKey);
                Auth::guard('web')->login($user, $this->remember);
                request()->session()->regenerate();

                $this->redirect(url('/admin'));

                return;
            }
        }

        // Customer: identified by phone number or email.
        $normalizedPhone = '0'.ltrim(preg_replace('/\D/', '', $identifier), '0');

        $pelanggan = Pelanggan::where('no_hp', $normalizedPhone)
            ->orWhere('email', $identifier)
            ->first();

        if (! $pelanggan || ! Hash::check($this->password, $pelanggan->password)) {
            RateLimiter::hit($throttleKey, 60);
            $this->addError('identifier', 'No. HP / email atau password salah.');

            return;
        }

        RateLimiter::clear($throttleKey);
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
