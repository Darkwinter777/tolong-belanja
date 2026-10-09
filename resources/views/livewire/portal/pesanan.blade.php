<div>
    <div class="rounded-b-[30px] px-[22px] pb-[62px] pt-[62px] text-white lg:px-10 lg:pt-10" style="background: linear-gradient(160deg, #00A88E, #006F5F);">
        <h1 class="text-[23px] font-extrabold text-white">Langganan Saya</h1>
        <p class="mt-1 text-sm text-white/85">Semua aktivitas Anda</p>
    </div>

    <div class="-mt-9 px-[16px] lg:px-8">
        @if ($this->activeLangganan)
            <a href="{{ route('portal.kost') }}" wire:navigate class="block rounded-[22px] bg-white p-4 shadow-md shadow-navy/10 ring-1 ring-black/5 transition active:scale-[0.98]">
                <div class="flex items-center gap-3">
                    <span class="flex h-[46px] w-[46px] shrink-0 basis-[46px] items-center justify-center rounded-[15px] bg-[#EAF6F3] text-brand-deep">
                        @svg('heroicon-s-home-modern', 'h-6 w-6')
                    </span>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <p class="text-[15px] font-extrabold text-ink">Langganan Aktif</p>
                            <span class="shrink-0 rounded-full bg-success-fill px-2 py-0.5 text-[9.5px] font-extrabold uppercase tracking-wide text-success-text">Aktif</span>
                        </div>
                        <p class="truncate text-[13px] text-text-secondary">Kamar {{ $this->activeLangganan->kamar?->nomor_kamar ?? '-' }}</p>
                    </div>
                    @svg('heroicon-o-chevron-right', 'h-5 w-5 shrink-0 text-text-faint')
                </div>
                <div class="mt-3 flex items-center justify-between rounded-2xl bg-field px-3.5 py-2.5">
                    <span class="text-xs text-text-muted">Sewa per bulan</span>
                    <span class="text-sm font-extrabold text-ink">Rp {{ number_format($this->activeLangganan->harga_bulanan, 0, ',', '.') }}</span>
                </div>
            </a>
        @else
            <div class="flex flex-col items-center gap-3 rounded-[22px] bg-white p-8 text-center shadow-md shadow-navy/10 ring-1 ring-black/5">
                <span class="flex h-14 w-14 shrink-0 basis-14 items-center justify-center rounded-full bg-field text-text-faint">
                    @svg('heroicon-o-home-modern', 'h-7 w-7')
                </span>
                <div>
                    <p class="text-sm font-semibold text-ink">Belum ada langganan aktif</p>
                    <p class="mt-1 text-xs text-text-faint">Cari kamar kost yang tersedia untuk mulai berlangganan.</p>
                </div>
            </div>
        @endif
    </div>

    <div class="space-y-3 px-[16px] pt-4 lg:grid lg:grid-cols-2 lg:gap-4 lg:space-y-0 lg:px-8 lg:pb-6">
        @forelse ($this->items as $item)
            <a href="{{ $item['url'] }}" wire:navigate class="flex items-center gap-3 rounded-[22px] bg-white p-4 shadow-sm ring-1 ring-black/5 transition active:scale-[0.98]">
                <span @class([
                    'flex h-[46px] w-[46px] shrink-0 basis-[46px] items-center justify-center rounded-[15px]',
                    'bg-[#EAF6F3] text-brand-deep' => $item['type'] === 'kost',
                    'bg-laundry-fill text-laundry-deep' => $item['type'] === 'laundry',
                ])>
                    @svg($item['icon'], 'h-6 w-6')
                </span>

                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <p class="truncate text-[15px] font-extrabold text-ink" style="max-width: 130px;">{{ $item['title'] }}</p>
                        <span @class([
                            'shrink-0 rounded-full px-2 py-0.5 text-[9.5px] font-extrabold uppercase tracking-wide',
                            'bg-[#EAF6F3] text-brand-deep' => $item['type'] === 'kost',
                            'bg-laundry-fill text-laundry-deep' => $item['type'] === 'laundry',
                        ])>
                            {{ $item['type'] === 'kost' ? 'Kost' : 'Laundry' }}
                        </span>
                    </div>
                    <p class="truncate text-[13px] text-text-secondary">{{ $item['subtitle'] }}</p>
                    <p class="mt-0.5 text-xs text-text-faint">{{ $item['date']->translatedFormat('d M Y') }}</p>
                </div>

                <span @class([
                    'shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold',
                    'bg-success-fill text-success-text' => in_array($item['status'], ['aktif', 'selesai', 'diambil']),
                    'bg-amber-fill text-amber-text' => in_array($item['status'], ['proses', 'diterima']),
                    'bg-[#EEF2F1] text-text-secondary' => $item['status'] === 'selesai' && $item['type'] === 'kost',
                    'bg-laundry-fill text-laundry-deep' => $item['status'] === 'dibatalkan',
                ])>
                    {{ $item['status'] === 'diambil' ? 'Selesai' : ucfirst($item['status']) }}
                </span>
            </a>
        @empty
            <div class="flex flex-col items-center gap-3 rounded-[22px] bg-white p-10 text-center lg:col-span-2 shadow-sm ring-1 ring-black/5">
                <span class="flex h-14 w-14 shrink-0 basis-14 items-center justify-center rounded-full bg-field text-text-faint">
                    @svg('heroicon-o-clipboard-document-list', 'h-7 w-7')
                </span>
                <div>
                    <p class="text-sm font-semibold text-ink">Belum ada pesanan</p>
                    <p class="mt-1 text-xs text-text-faint">Aktivitas kost & laundry Anda akan muncul di sini.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
