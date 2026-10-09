<div>
    <div class="sticky top-0 z-20 border-b border-divider bg-white px-[22px] pb-4 pt-[62px] lg:pt-5">
        <div class="flex items-center gap-3">
            @if ($step === 1)
                <a href="{{ route('portal.home') }}" wire:navigate class="flex h-10 w-10 shrink-0 basis-10 items-center justify-center rounded-[13px] bg-field text-ink">
                    @svg('heroicon-o-arrow-left', 'h-5 w-5')
                </a>
            @else
                <button type="button" wire:click="prevStep" class="flex h-10 w-10 shrink-0 basis-10 items-center justify-center rounded-[13px] bg-field text-ink">
                    @svg('heroicon-o-arrow-left', 'h-5 w-5')
                </button>
            @endif
            <div class="min-w-0 flex-1">
                <h1 class="text-base font-extrabold text-ink">Order Laundry</h1>
                <p class="text-xs text-text-muted">
                    Langkah {{ $step }} dari 3 · {{ $step === 1 ? 'Pilih layanan' : ($step === 2 ? 'Jumlah' : 'Jemput & ringkasan') }}
                </p>
            </div>
        </div>
        <div class="mt-3 grid grid-cols-3 gap-1.5">
            @for ($i = 1; $i <= 3; $i++)
                <div class="h-1 rounded-full {{ $i <= $step ? 'bg-laundry-deep' : 'bg-[#E6ECEA]' }}"></div>
            @endfor
        </div>
    </div>

    <div class="space-y-3 px-[16px] py-4 pb-32">
        @if ($step === 1)
            @forelse ($this->layanans as $l)
                <button
                    type="button"
                    wire:click="pilihLayanan({{ $l->id }})"
                    class="flex w-full items-center justify-between rounded-[22px] border-2 bg-white p-4 text-left shadow-sm ring-1 ring-black/5 {{ $layananId === $l->id ? 'border-laundry-deep' : 'border-transparent' }}"
                >
                    <div>
                        <p class="font-extrabold text-ink">{{ $l->nama_layanan }}</p>
                        <p class="mt-1 text-[15px] font-extrabold text-laundry-deep">
                            Rp {{ number_format($l->harga, 0, ',', '.') }} <span class="text-xs font-normal text-text-faint">/ {{ $l->satuan }}</span>
                        </p>
                    </div>
                    <span @class([
                        'flex h-[22px] w-[22px] shrink-0 basis-[22px] items-center justify-center rounded-full border-2',
                        'border-laundry-deep bg-laundry-deep' => $layananId === $l->id,
                        'border-border' => $layananId !== $l->id,
                    ]) style="{{ $layananId === $l->id ? 'box-shadow: inset 0 0 0 4px #fff;' : '' }}"></span>
                </button>
            @empty
                <div class="rounded-[22px] bg-white p-8 text-center shadow-sm ring-1 ring-black/5">
                    <p class="text-sm font-semibold text-ink">Belum ada layanan tersedia</p>
                </div>
            @endforelse
        @endif

        @if ($step === 2)
            <div class="rounded-[22px] bg-white p-4 shadow-sm ring-1 ring-black/5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-extrabold text-ink">{{ $this->layanan?->nama_layanan }}</p>
                        <p class="text-xs text-text-muted">Satuan: {{ $this->layanan?->satuan }}</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-center gap-5">
                    <button type="button" wire:click="kurangiJumlah" class="flex h-[34px] w-[34px] items-center justify-center rounded-[11px] border-[1.5px] border-border text-ink">
                        @svg('heroicon-o-minus', 'h-4 w-4')
                    </button>
                    <span class="min-w-[48px] text-center text-[15px] font-extrabold text-ink">{{ $jumlah }}</span>
                    <button type="button" wire:click="tambahJumlah" class="flex h-[34px] w-[34px] items-center justify-center rounded-[11px] bg-laundry-deep text-white">
                        @svg('heroicon-o-plus', 'h-4 w-4')
                    </button>
                </div>
            </div>
        @endif

        @if ($step === 3)
            <div class="rounded-[22px] bg-white p-4 shadow-sm ring-1 ring-black/5">
                <p class="mb-3 text-[11px] font-extrabold uppercase tracking-[0.1em] text-text-faint">Jadwal Jemput</p>
                <div class="grid grid-cols-1 gap-2">
                    @foreach ($this->slots as $i => $slot)
                        <button
                            type="button"
                            wire:click="$set('slotIdx', {{ $i }})"
                            class="flex h-12 items-center justify-center rounded-2xl border-[1.5px] text-sm font-bold {{ $slotIdx === $i ? 'border-laundry-deep bg-laundry-deep text-white' : 'border-border text-ink' }}"
                        >
                            {{ $slot['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="rounded-[22px] bg-white p-4 shadow-sm ring-1 ring-black/5">
                <label class="mb-2 block text-xs font-bold text-text-secondary">Alamat / Catatan (opsional)</label>
                <textarea wire:model="catatan" rows="2" placeholder="Contoh: Kamar C03, titip ke satpam" class="w-full rounded-xl border-[1.5px] border-border bg-field p-3 text-sm text-ink placeholder:text-text-faint focus:border-laundry-deep focus:outline-none"></textarea>
            </div>

            <div class="rounded-[22px] bg-white p-4 shadow-sm ring-1 ring-black/5">
                <p class="mb-3 text-[11px] font-extrabold uppercase tracking-[0.1em] text-text-faint">Ringkasan</p>
                <div class="flex justify-between text-sm">
                    <span class="text-text-secondary">{{ $this->layanan?->nama_layanan }} ({{ $jumlah }} {{ $this->layanan?->satuan }})</span>
                    <span class="font-bold text-ink">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
                </div>
                <div class="my-3 h-px bg-divider"></div>
                <div class="flex justify-between">
                    <span class="text-[15px] font-extrabold text-ink">Total</span>
                    <span class="text-[19px] font-extrabold text-ink">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
                </div>
            </div>
        @endif
    </div>

    <div class="fixed bottom-0 left-1/2 z-30 w-full max-w-md -translate-x-1/2 lg:max-w-xl px-4 pb-[max(1rem,env(safe-area-inset-bottom))]" style="background: linear-gradient(180deg, transparent, rgba(244,247,247,.96) 32%);">
        <div class="flex items-center justify-between rounded-[22px] bg-white p-3 pl-4 shadow-lg ring-1 ring-black/5">
            <div>
                <p class="text-[11px] text-text-faint">{{ $step === 3 ? 'Total' : 'Estimasi' }}</p>
                <p class="text-base font-extrabold text-ink">Rp {{ number_format($this->total, 0, ',', '.') }}</p>
            </div>
            @if ($step < 3)
                <button type="button" wire:click="nextStep" class="flex h-[50px] items-center rounded-2xl bg-laundry-deep px-6 text-sm font-extrabold text-white shadow-[0_10px_22px_-12px_rgba(230,34,74,0.6)]">
                    Lanjut
                </button>
            @else
                <button type="button" wire:click="submit" wire:loading.attr="disabled" class="flex h-[50px] items-center rounded-2xl bg-laundry-deep px-6 text-sm font-extrabold text-white shadow-[0_10px_22px_-12px_rgba(230,34,74,0.6)]">
                    <span wire:loading.remove>Pesan sekarang</span>
                    <span wire:loading>Memproses...</span>
                </button>
            @endif
        </div>
    </div>
</div>
