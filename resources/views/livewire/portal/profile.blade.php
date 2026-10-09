<div
    x-data="{ toast: '', editingProfile: false, editingPassword: false }"
    @profile-updated.window="toast = 'Profil diperbarui'; editingProfile = false; setTimeout(() => toast = '', 2000)"
    @password-updated.window="toast = 'Password diperbarui'; editingPassword = false; setTimeout(() => toast = '', 2000)"
>
    <div class="rounded-b-[30px] px-6 pb-10 pt-12 text-center text-white" style="background: linear-gradient(160deg, #00A88E, #00655A);">
        <div class="mx-auto flex h-[88px] w-[88px] items-center justify-center rounded-full text-[24px] font-extrabold" style="background: rgba(255,255,255,.18);">
            {{ strtoupper(substr($nama, 0, 1)) }}
        </div>
        <h1 class="mt-4 text-[18px] font-extrabold">{{ $nama }}</h1>
        <p class="text-[13.5px] text-white/85">{{ $email }}</p>

        <div class="mt-3 flex justify-center gap-2">
            @if ($this->penghuniAktif)
                @php $kontrak = $this->penghuniAktif->kontrakSewas->first(); @endphp
                <span class="rounded-full bg-amber-fill px-3 py-1 text-[10px] font-extrabold uppercase tracking-wide text-amber-text-deep">
                    Penghuni · {{ $kontrak?->kamar?->nomor_kamar }}
                </span>
            @endif
            <span class="rounded-full px-3 py-1 text-[10px] font-semibold text-white/85" style="background: rgba(255,255,255,.15);">
                Sejak {{ Auth::guard('pelanggan')->user()->created_at->translatedFormat('M Y') }}
            </span>
        </div>
    </div>

    <div
        x-show="toast"
        x-transition
        x-cloak
        class="mx-4 mt-4 flex items-center gap-2 rounded-xl bg-success-fill px-4 py-2.5 text-sm font-medium text-success-text ring-1 ring-emerald-100"
    >
        @svg('heroicon-s-check-circle', 'h-4 w-4')
        <span x-text="toast"></span>
    </div>

    <div class="-mt-8 space-y-4 px-4">
        <div class="overflow-hidden rounded-[22px] bg-white shadow-lg shadow-navy/5 ring-1 ring-black/5">
            <p class="px-4 pt-4 text-xs font-extrabold uppercase tracking-wide text-text-faint">Akun</p>

            <button
                type="button"
                @click="editingProfile = !editingProfile"
                class="flex w-full items-center gap-3 px-4 py-3.5 text-left transition hover:bg-field"
            >
                <span class="flex h-10 w-10 shrink-0 basis-10 items-center justify-center rounded-[13px] bg-[#EAF6F3] text-brand-deep">
                    @svg('heroicon-o-identification', 'h-5 w-5')
                </span>
                <span class="flex-1 text-[15px] font-medium text-ink">Data Diri</span>
                @svg('heroicon-o-chevron-down', 'h-4 w-4 text-text-faint transition', ['x-bind:class' => "editingProfile ? 'rotate-180' : ''"])
            </button>

            <div x-show="editingProfile" x-collapse x-cloak class="border-t border-divider-soft px-4 pb-4 pt-3">
                <form wire:submit="updateProfile" class="space-y-3">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-text-secondary">Nama</label>
                        <input type="text" wire:model="nama" class="w-full rounded-xl border border-border bg-field px-3 py-2 text-sm focus:border-brand focus:outline-none focus:ring-0">
                        @error('nama') <p class="mt-1 text-xs text-laundry-deep">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-text-secondary">Email</label>
                        <input type="email" wire:model="email" class="w-full rounded-xl border border-border bg-field px-3 py-2 text-sm focus:border-brand focus:outline-none focus:ring-0">
                        @error('email') <p class="mt-1 text-xs text-laundry-deep">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-text-secondary">No. HP</label>
                        <input type="text" wire:model="no_hp" class="w-full rounded-xl border border-border bg-field px-3 py-2 text-sm focus:border-brand focus:outline-none focus:ring-0">
                    </div>
                    <button type="submit" class="w-full rounded-xl bg-brand py-2.5 text-sm font-bold text-white transition hover:bg-brand-hover">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <div class="border-t border-divider-soft"></div>

            <button
                type="button"
                @click="editingPassword = !editingPassword"
                class="flex w-full items-center gap-3 px-4 py-3.5 text-left transition hover:bg-field"
            >
                <span class="flex h-10 w-10 shrink-0 basis-10 items-center justify-center rounded-[13px] bg-amber-fill text-amber-text-deep">
                    @svg('heroicon-o-lock-closed', 'h-5 w-5')
                </span>
                <span class="flex-1 text-[15px] font-medium text-ink">Ganti Password</span>
                @svg('heroicon-o-chevron-down', 'h-4 w-4 text-text-faint transition', ['x-bind:class' => "editingPassword ? 'rotate-180' : ''"])
            </button>

            <div x-show="editingPassword" x-collapse x-cloak class="border-t border-divider-soft px-4 pb-4 pt-3">
                <form wire:submit="updatePassword" class="space-y-3">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-text-secondary">Password Baru</label>
                        <input type="password" wire:model="password" class="w-full rounded-xl border border-border bg-field px-3 py-2 text-sm focus:border-brand focus:outline-none focus:ring-0">
                        @error('password') <p class="mt-1 text-xs text-laundry-deep">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-text-secondary">Konfirmasi Password</label>
                        <input type="password" wire:model="password_confirmation" class="w-full rounded-xl border border-border bg-field px-3 py-2 text-sm focus:border-brand focus:outline-none focus:ring-0">
                    </div>
                    <button type="submit" class="w-full rounded-xl border-[1.5px] border-brand py-2.5 text-sm font-bold text-brand transition hover:bg-[#F2F9F7]">
                        Ubah Password
                    </button>
                </form>
            </div>

            <div class="border-t border-divider-soft"></div>

            <a href="{{ route('portal.pembayaran') }}" wire:navigate class="flex w-full items-center gap-3 px-4 py-3.5 text-left transition hover:bg-field">
                <span class="flex h-10 w-10 shrink-0 basis-10 items-center justify-center rounded-[13px] bg-[#EAF6F3] text-brand-deep">
                    @svg('heroicon-o-credit-card', 'h-5 w-5')
                </span>
                <span class="flex-1 text-[15px] font-medium text-ink">Metode Pembayaran</span>
                @svg('heroicon-o-chevron-right', 'h-4 w-4 text-text-faint')
            </a>
        </div>

        <div class="overflow-hidden rounded-[22px] bg-white shadow-sm ring-1 ring-black/5">
            <p class="px-4 pt-4 text-xs font-extrabold uppercase tracking-wide text-text-faint">Bantuan</p>
            <div class="flex items-center gap-3 px-4 py-3.5">
                <span class="flex h-10 w-10 shrink-0 basis-10 items-center justify-center rounded-[13px] bg-sky-50 text-sky-600">
                    @svg('heroicon-o-lifebuoy', 'h-5 w-5')
                </span>
                <span class="flex-1 text-[15px] font-medium text-ink">Pusat Bantuan</span>
                @svg('heroicon-o-chevron-right', 'h-4 w-4 text-text-faint')
            </div>
        </div>

        <button
            wire:click="logout"
            wire:confirm="Yakin mau keluar?"
            class="flex h-[54px] w-full items-center justify-center gap-2 rounded-[18px] border-[1.5px] border-laundry-border bg-laundry-bg text-[15px] font-extrabold text-laundry-deep transition hover:bg-laundry-fill"
        >
            @svg('heroicon-o-arrow-right-start-on-rectangle', 'h-4 w-4')
            Keluar
        </button>

        <p class="pb-2 text-center text-xs text-text-faint">Tolong Belanja v1.0</p>
    </div>
</div>
