<div class="min-h-screen bg-white">
    <div class="flex min-h-screen flex-col px-[26px] pb-10 pt-16">
        <div class="flex h-[62px] w-[62px] shrink-0 basis-[62px] items-center justify-center overflow-hidden rounded-[20px] shadow-[0_10px_24px_-8px_rgba(0,128,108,0.6)]" style="background: linear-gradient(140deg, #00B294, #00806C);">
            <img src="{{ asset('logo.png') }}" alt="Tolong Belanja" class="h-full w-full object-cover">
        </div>

        <h1 class="mt-6 text-[24px] font-extrabold leading-tight tracking-[-0.03em] text-ink text-wrap-pretty">Buat akun baru</h1>
        <p class="mt-2 text-sm text-text-faint">Daftar untuk mulai kelola kost & laundry Anda.</p>

        <form wire:submit="register" class="mt-8 space-y-4">
            <div>
                <label class="mb-2 block text-xs font-bold text-text-secondary">Nama Lengkap</label>
                <input
                    type="text"
                    wire:model="nama"
                    class="h-14 w-full rounded-2xl border-[1.5px] border-border bg-field px-4 text-sm text-ink placeholder:text-text-faint focus:border-brand focus:outline-none focus:ring-0"
                >
                @error('nama') <p class="mt-1.5 text-xs text-laundry-deep">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-2 block text-xs font-bold text-text-secondary">Email</label>
                <input
                    type="email"
                    wire:model="email"
                    class="h-14 w-full rounded-2xl border-[1.5px] border-border bg-field px-4 text-sm text-ink placeholder:text-text-faint focus:border-brand focus:outline-none focus:ring-0"
                >
                @error('email') <p class="mt-1.5 text-xs text-laundry-deep">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-2 block text-xs font-bold text-text-secondary">No. HP</label>
                <div class="flex h-14 items-center rounded-2xl border-[1.5px] border-border bg-field px-4 focus-within:border-brand">
                    <span class="text-sm font-semibold text-ink">+62</span>
                    <span class="mx-3 h-[22px] w-px bg-[#D8E2E1]"></span>
                    <input type="tel" wire:model="no_hp" inputmode="numeric" class="h-full flex-1 border-0 bg-transparent p-0 text-sm text-ink placeholder:text-text-faint focus:outline-none focus:ring-0">
                </div>
                @error('no_hp') <p class="mt-1.5 text-xs text-laundry-deep">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-2 block text-xs font-bold text-text-secondary">Password</label>
                <input
                    type="password"
                    wire:model="password"
                    class="h-14 w-full rounded-2xl border-[1.5px] border-border bg-field px-4 text-sm text-ink placeholder:text-text-faint focus:border-brand focus:outline-none focus:ring-0"
                >
                @error('password') <p class="mt-1.5 text-xs text-laundry-deep">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-2 block text-xs font-bold text-text-secondary">Konfirmasi Password</label>
                <input
                    type="password"
                    wire:model="password_confirmation"
                    class="h-14 w-full rounded-2xl border-[1.5px] border-border bg-field px-4 text-sm text-ink placeholder:text-text-faint focus:border-brand focus:outline-none focus:ring-0"
                >
            </div>

            <button
                type="submit"
                class="h-14 w-full rounded-[18px] bg-brand text-[15px] font-extrabold text-white shadow-[0_10px_22px_-12px_rgba(0,168,142,1)] transition hover:bg-brand-hover active:translate-y-px"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>Daftar</span>
                <span wire:loading>Memproses...</span>
            </button>
        </form>

        <p class="mt-auto pt-8 text-center text-sm text-text-muted">
            Sudah punya akun?
            <a href="{{ route('portal.login') }}" wire:navigate class="font-bold text-brand">Masuk</a>
        </p>
    </div>
</div>
