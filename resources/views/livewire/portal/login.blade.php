<div x-data="{ toast: false }" @coming-soon.window="toast = true; setTimeout(() => toast = false, 2500)" class="min-h-screen bg-white">
    <div class="flex min-h-screen flex-col px-[26px] pb-10 pt-24">
        <div class="flex h-[62px] w-[62px] shrink-0 basis-[62px] items-center justify-center overflow-hidden rounded-[20px] shadow-[0_10px_24px_-8px_rgba(0,128,108,0.6)]" style="background: linear-gradient(140deg, #00B294, #00806C);">
            <img src="{{ asset('logo.png') }}" alt="Tolong Belanja" class="h-full w-full object-cover">
        </div>

        <h1 class="mt-6 text-[25px] font-extrabold leading-tight tracking-[-0.03em] text-ink text-wrap-pretty">Selamat datang kembali</h1>
        <p class="mt-2 text-sm text-text-faint">
            Masuk untuk kelola kost & laundry Anda.<br>
            <span class="text-[13px]">Sign in to manage your stay & laundry.</span>
        </p>

        <form wire:submit="login" class="mt-8 space-y-5">
            <div>
                <label class="mb-2 block text-xs font-bold text-text-secondary">No. HP atau Email</label>
                <div class="flex h-14 items-center rounded-2xl border-[1.5px] border-border bg-field px-4 focus-within:border-brand">
                    <input
                        type="text"
                        wire:model="identifier"
                        autocomplete="username"
                        autocapitalize="none"
                        class="h-full flex-1 border-0 bg-transparent p-0 text-sm text-ink placeholder:text-text-faint focus:outline-none focus:ring-0"
                    >
                </div>
                @error('identifier') <p class="mt-1.5 text-xs text-laundry-deep">{{ $message }}</p> @enderror
            </div>

            <div x-data="{ show: false }">
                <div class="mb-2 flex items-center justify-between">
                    <label class="text-xs font-bold text-text-secondary">Password</label>
                    <button type="button" wire:click="comingSoon" class="text-xs font-bold text-brand">Lupa?</button>
                </div>
                <div class="relative flex h-14 items-center rounded-2xl border-[1.5px] border-border bg-field px-4 focus-within:border-brand">
                    <input
                        :type="show ? 'text' : 'password'"
                        wire:model="password"
                        class="h-full flex-1 border-0 bg-transparent p-0 text-sm text-ink placeholder:text-text-faint focus:outline-none focus:ring-0"
                    >
                    <button type="button" @click="show = !show" class="text-text-faint">
                        <span x-show="!show">@svg('heroicon-o-eye', 'h-5 w-5')</span>
                        <span x-show="show" x-cloak>@svg('heroicon-o-eye-slash', 'h-5 w-5')</span>
                    </button>
                </div>
                @error('password') <p class="mt-1.5 text-xs text-laundry-deep">{{ $message }}</p> @enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-text-secondary">
                <input type="checkbox" wire:model="remember" class="rounded border-border text-brand focus:ring-brand">
                Ingat saya
            </label>

            <button
                type="submit"
                class="h-14 w-full rounded-[18px] bg-brand text-[15px] font-extrabold text-white shadow-[0_10px_22px_-12px_rgba(0,168,142,1)] transition hover:bg-brand-hover active:translate-y-px"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>Masuk</span>
                <span wire:loading>Memproses...</span>
            </button>
        </form>

        <div class="my-[22px] flex items-center gap-3">
            <div class="h-px flex-1 bg-divider"></div>
            <span class="text-[11px] text-text-faint">atau</span>
            <div class="h-px flex-1 bg-divider"></div>
        </div>

        <button
            type="button"
            wire:click="comingSoon"
            class="flex h-[54px] w-full items-center justify-center gap-2 rounded-[18px] border-[1.5px] border-border bg-white text-sm font-medium text-ink transition hover:bg-[#F7FAF9]"
        >
            <svg class="h-4 w-4" viewBox="0 0 48 48">
                <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3c-1.6 4.6-6 8-11.3 8-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.6 6.1 29.6 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.7-.4-3.5z"/>
                <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.6 16 19 13 24 13c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.6 6.1 29.6 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/>
                <path fill="#4CAF50" d="M24 44c5.5 0 10.4-1.9 14.3-5.1l-6.6-5.6C29.6 35.1 26.9 36 24 36c-5.2 0-9.6-3.4-11.3-8l-6.6 5.1C9.6 39.6 16.3 44 24 44z"/>
                <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.3-2.2 4.2-4.1 5.6l6.6 5.6C40.4 36.6 44 31 44 24c0-1.3-.1-2.7-.4-3.5z"/>
            </svg>
            Masuk dengan Google
        </button>

        <p class="mt-auto pt-8 text-center text-sm text-text-muted">
            Belum punya akun?
            <a href="{{ route('portal.register') }}" wire:navigate class="font-bold text-brand">Daftar</a>
        </p>
    </div>

    <div
        x-show="toast"
        x-transition
        x-cloak
        class="fixed bottom-6 left-1/2 z-50 w-[calc(100%-3rem)] max-w-xs -translate-x-1/2 rounded-xl bg-ink px-4 py-3 text-center text-sm text-white shadow-lg"
    >
        Fitur ini segera hadir 🚀
    </div>
</div>
