<div>
    <div class="relative overflow-hidden bg-navy px-[22px] pb-12 pt-[45px] lg:px-10 lg:pb-14 lg:pt-10">
        <div class="pointer-events-none absolute -right-[70px] -top-[60px] h-[220px] w-[220px] rounded-full" style="background: rgba(0,168,142,.22);"></div>
        <div class="pointer-events-none absolute right-10 top-[120px] h-[120px] w-[120px] rounded-full" style="background: rgba(255,192,67,.12);"></div>

        <div class="relative flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 basis-11 items-center justify-center overflow-hidden rounded-[14px] shadow-sm" style="background: linear-gradient(140deg, #00B294, #00806C);">
                    <img src="{{ asset('logo.png') }}" alt="Tolong Belanja" class="h-full w-full object-cover">
                </div>
                <div>
                    <p class="text-xs text-white/70">Halo,</p>
                    <h1 class="text-[16px] font-extrabold leading-tight text-white">{{ $this->pelanggan->nama }}</h1>
                </div>
            </div>

            <a href="{{ route('portal.notifikasi') }}" wire:navigate class="relative flex h-11 w-11 shrink-0 basis-11 items-center justify-center rounded-full" style="background: rgba(255,255,255,.1);">
                @svg('heroicon-o-bell', 'h-5 w-5 text-white')
                @if ($this->pelanggan->unreadNotifications()->count() > 0)
                    <span class="absolute right-2.5 top-2.5 h-2 w-2 rounded-full bg-amber-from ring-2 ring-navy"></span>
                @endif
            </a>
        </div>

        <p class="relative mt-6 text-wrap-pretty text-[22px] font-extrabold leading-tight tracking-[-0.03em] text-white">
            Kemudahan kelola<br>di genggaman Anda.
        </p>
    </div>

    <div class="px-[18px] pt-7 lg:px-10">
        <div class="mb-3">
            <p class="text-[15px] font-extrabold text-ink">Layanan Kami</p>
        </div>

        <div class="grid grid-cols-2 gap-3 lg:grid-cols-3 lg:gap-4">
            <a href="{{ route('portal.kost.book') }}" wire:navigate class="relative col-span-2 flex h-[158px] lg:col-span-1 lg:h-[200px] flex-col justify-end overflow-hidden rounded-[24px] bg-cover bg-center p-4 shadow-md transition active:scale-[0.97]" style="background-image: url('{{ asset('images/kost-cover.jpg') }}');">
                <div class="absolute inset-0" style="background: linear-gradient(0deg, rgba(11,37,64,.82) 0%, rgba(11,37,64,0) 55%);"></div>
                <div class="relative">
                    <span class="inline-block rounded-full bg-brand px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wide text-white">
                        {{ $this->kamarKosongCount }} Kamar Kosong
                    </span>
                    <p class="mt-2 text-[17px] font-extrabold leading-tight text-white">Booking Kost</p>
                    @if ($this->kamarTermurah)
                        <p class="text-xs text-white/85">Mulai Rp {{ number_format($this->kamarTermurah->harga, 0, ',', '.') }} / bulan</p>
                    @endif
                </div>
            </a>

            <a href="{{ route('portal.laundry.book') }}" wire:navigate class="relative flex h-[132px] flex-col justify-end overflow-hidden rounded-[22px] bg-cover bg-center p-3.5 shadow-md lg:h-[200px] transition active:scale-[0.97]" style="background-image: url('{{ asset('images/laundry-cover.jpg') }}');">
                <div class="absolute inset-0" style="background: linear-gradient(0deg, rgba(11,37,64,.82) 0%, rgba(11,37,64,0) 55%);"></div>
                <div class="relative">
                    <p class="text-[14px] font-extrabold leading-tight text-white">Laundry</p>
                    <p class="text-[11px] text-white/85">Antar jemput</p>
                </div>
            </a>

            <div class="relative flex h-[132px] flex-col justify-end overflow-hidden rounded-[22px] bg-cover bg-center p-3.5 opacity-50 shadow-md lg:h-[200px]" style="background-image: url('{{ asset('images/cafe-cover.jpg') }}');">
                <div class="absolute inset-0" style="background: linear-gradient(0deg, rgba(11,37,64,.82) 0%, rgba(11,37,64,0) 55%);"></div>
                <div class="relative">
                    <p class="text-[14px] font-extrabold leading-tight text-white">Cafe</p>
                    <p class="text-[11px] text-white/85">Segera hadir</p>
                </div>
            </div>
        </div>
    </div>

    @if ($this->currentOrder)
        <div class="px-[18px] pt-6 lg:px-10">
            <a href="{{ route('portal.laundry.detail', $this->currentOrder['order']) }}" wire:navigate class="block rounded-[22px] bg-white p-4 shadow-md shadow-navy/5 ring-1 ring-black/5">
                <p class="mb-3 text-[13px] font-extrabold text-ink">Sedang berjalan</p>
                <div class="flex items-center gap-3">
                    <span class="flex h-[46px] w-[46px] shrink-0 basis-[46px] items-center justify-center rounded-2xl bg-laundry-fill text-laundry-deep">
                        @svg('heroicon-s-sparkles', 'h-6 w-6')
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-extrabold text-ink">{{ $this->currentOrder['order']->layanan?->nama_layanan }}</p>
                        <p class="truncate text-xs text-text-muted">{{ $this->currentOrder['order']->kode_order }}</p>
                    </div>
                    <span class="shrink-0 rounded-full bg-amber-fill px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wide text-amber-text">
                        {{ $this->currentOrder['order']->status === 'diterima' ? 'Diterima' : 'Proses' }}
                    </span>
                </div>
                <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-divider">
                    <div class="h-full rounded-full bg-brand" style="width: {{ $this->currentOrder['progress'] }}%"></div>
                </div>
                <p class="mt-2 text-[11px] text-text-faint">
                    Estimasi selesai: {{ $this->currentOrder['order']->estimasi_selesai?->format('d M, H:i') ?? '-' }}
                </p>
            </a>
        </div>
    @endif

    <div class="px-[18px] pt-6 lg:px-10">
        <div class="overflow-hidden rounded-[22px] p-5 text-white shadow-md" style="background: linear-gradient(120deg, #FFC043, #FF8A00);">
            <p class="text-[11px] font-extrabold uppercase tracking-[0.12em] text-white/80">Info</p>
            <p class="mt-1 text-base font-extrabold">Pantau tagihan & order Anda di sini</p>
            <p class="mt-1 text-[13px] text-white/90">Semua riwayat kost & laundry Anda tercatat rapi dan real-time.</p>
        </div>
    </div>
</div>
