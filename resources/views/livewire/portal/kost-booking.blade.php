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
                <h1 class="text-base font-extrabold text-ink">Booking Kost</h1>
                <p class="text-xs text-text-muted">
                    Langkah {{ $step }} dari 3 · {{ $step === 1 ? 'Pilih kamar' : ($step === 2 ? 'Tanggal & durasi' : 'Ringkasan') }}
                </p>
            </div>
        </div>
        <div class="mt-3 grid grid-cols-3 gap-1.5">
            @for ($i = 1; $i <= 3; $i++)
                <div class="h-1 rounded-full {{ $i <= $step ? 'bg-brand' : 'bg-[#E6ECEA]' }}"></div>
            @endfor
        </div>
    </div>

    <div class="space-y-3 px-[16px] py-4 pb-32">
        @if ($step === 1)
            @forelse ($this->kamars as $k)
                <button
                    type="button"
                    wire:click="pilihKamar({{ $k->id }})"
                    class="flex w-full items-center gap-3 rounded-[22px] border-2 p-3.5 text-left transition {{ $kamarId === $k->id ? 'border-brand' : 'border-transparent' }} bg-white shadow-sm ring-1 ring-black/5"
                >
                    @if ($foto = ($k->foto_kamar[0] ?? null))
                        <img src="{{ asset('storage/'.$foto) }}" alt="Kamar {{ $k->nomor_kamar }}" class="h-[84px] w-[84px] shrink-0 basis-[84px] rounded-[18px] object-cover">
                    @else
                        <div class="h-[84px] w-[84px] shrink-0 basis-[84px] rounded-[18px]" style="background: linear-gradient(160deg, #93A5A3, #DDE5E4);"></div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <p class="font-extrabold text-ink">Kamar {{ $k->nomor_kamar }}</p>
                        <p class="text-xs text-text-muted">{{ $k->tipe ?? 'Kamar standar' }}</p>
                        <p class="mt-1 text-[15px] font-extrabold text-brand">
                            Rp {{ number_format($k->harga, 0, ',', '.') }}
                            <span class="text-xs font-normal text-text-faint">/ bulan</span>
                        </p>
                    </div>
                    <span @class([
                        'flex h-[22px] w-[22px] shrink-0 basis-[22px] items-center justify-center rounded-full border-2',
                        'border-brand bg-brand' => $kamarId === $k->id,
                        'border-border' => $kamarId !== $k->id,
                    ]) style="{{ $kamarId === $k->id ? 'box-shadow: inset 0 0 0 4px #fff;' : '' }}"></span>
                </button>
            @empty
                <div class="rounded-[22px] bg-white p-8 text-center shadow-sm ring-1 ring-black/5">
                    <p class="text-sm font-semibold text-ink">Semua kamar sedang terisi</p>
                    <p class="mt-1 text-xs text-text-faint">Silakan hubungi pengelola untuk info ketersediaan.</p>
                </div>
            @endforelse
        @endif

        @if ($step === 2)
            <div class="rounded-[22px] bg-white p-4 shadow-sm ring-1 ring-black/5">
                <p class="mb-3 text-[11px] font-extrabold uppercase tracking-[0.1em] text-text-faint">Tanggal Masuk</p>
                <div class="grid grid-cols-4 gap-2">
                    @foreach ($this->dateOptions as $i => $date)
                        <button
                            type="button"
                            wire:click="$set('dateOffset', {{ $i }})"
                            class="flex h-[60px] flex-col items-center justify-center rounded-2xl border-[1.5px] {{ $dateOffset === $i ? 'border-brand bg-brand text-white' : 'border-border text-ink' }}"
                        >
                            <span class="text-[10px] font-semibold uppercase opacity-80">{{ $date->translatedFormat('D') }}</span>
                            <span class="text-sm font-extrabold">{{ $date->format('d') }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="rounded-[22px] bg-white p-4 shadow-sm ring-1 ring-black/5">
                <p class="mb-3 text-[11px] font-extrabold uppercase tracking-[0.1em] text-text-faint">Durasi Sewa</p>
                <div class="grid grid-cols-3 gap-2">
                    @foreach ([1, 3, 6] as $bulan)
                        <button
                            type="button"
                            wire:click="$set('durasiBulan', {{ $bulan }})"
                            class="flex h-12 items-center justify-center rounded-2xl border-[1.5px] text-sm font-bold {{ $durasiBulan === $bulan ? 'border-brand bg-brand text-white' : 'border-border text-ink' }}"
                        >
                            {{ $bulan }} bulan
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex items-start gap-2 rounded-2xl bg-[#F2F9F7] p-4">
                @svg('heroicon-o-information-circle', 'h-5 w-5 shrink-0 text-brand-deep')
                <p class="text-[12.5px] leading-relaxed text-[#2F6B60]">
                    Sewa 6 bulan bisa dapat harga lebih hemat — tanya pengelola kost untuk info promo.
                </p>
            </div>
        @endif

        @if ($step === 3 && $this->kamar)
            <div class="rounded-[22px] bg-white p-4 shadow-sm ring-1 ring-black/5">
                <div class="flex items-center gap-3">
                    <div class="h-[70px] w-[70px] shrink-0 basis-[70px] rounded-2xl" style="background: linear-gradient(160deg, #93A5A3, #DDE5E4);"></div>
                    <div class="min-w-0 flex-1">
                        <p class="font-extrabold text-ink">Kamar {{ $this->kamar->nomor_kamar }}</p>
                        <p class="text-xs text-text-muted">Masuk {{ $this->tanggalMulai->translatedFormat('d M Y') }} · {{ $durasiBulan }} bulan</p>
                    </div>
                </div>
                <div class="my-4 h-px bg-divider"></div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-text-secondary">Sewa kamar ({{ $durasiBulan }} × Rp {{ number_format($this->kamar->harga, 0, ',', '.') }})</span>
                        <span class="font-bold text-ink">Rp {{ number_format($this->biaya['sewa'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-text-secondary">Deposit</span>
                        <span class="font-bold text-ink">Rp {{ number_format($this->biaya['deposit'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-text-secondary">Biaya admin</span>
                        <span class="font-bold text-ink">Rp {{ number_format($this->biaya['admin'], 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="my-4 h-px bg-divider"></div>
                <div class="flex justify-between">
                    <span class="text-[15px] font-extrabold text-ink">Total</span>
                    <span class="text-[19px] font-extrabold text-ink">Rp {{ number_format($this->biaya['total'], 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="rounded-[22px] bg-white p-4 shadow-sm ring-1 ring-black/5">
                <label class="mb-2 block text-xs font-bold text-text-secondary">Catatan (opsional)</label>
                <textarea wire:model="catatan" rows="3" placeholder="Contoh: titip kunci ke satpam" class="w-full rounded-xl border-[1.5px] border-border bg-field p-3 text-sm text-ink placeholder:text-text-faint focus:border-brand focus:outline-none"></textarea>
            </div>
        @endif
    </div>

    <div class="fixed bottom-0 left-1/2 z-30 w-full max-w-md -translate-x-1/2 lg:max-w-xl px-4 pb-[max(1rem,env(safe-area-inset-bottom))]" style="background: linear-gradient(180deg, transparent, rgba(244,247,247,.96) 32%);">
        <div class="flex items-center justify-between rounded-[22px] bg-white p-3 pl-4 shadow-lg ring-1 ring-black/5">
            <div>
                <p class="text-[11px] text-text-faint">{{ $step === 3 ? 'Total pembayaran pertama' : 'Mulai dari' }}</p>
                <p class="text-base font-extrabold text-ink">
                    Rp {{ number_format($step === 3 ? $this->biaya['total'] : ($this->kamar->harga ?? 0), 0, ',', '.') }}
                </p>
            </div>
            @if ($step < 3)
                <button type="button" wire:click="nextStep" class="flex h-[50px] items-center rounded-2xl bg-brand px-6 text-sm font-extrabold text-white shadow-[0_10px_22px_-12px_rgba(0,168,142,1)]">
                    Lanjut
                </button>
            @else
                <button type="button" wire:click="submit" wire:loading.attr="disabled" class="flex h-[50px] items-center rounded-2xl bg-brand px-6 text-sm font-extrabold text-white shadow-[0_10px_22px_-12px_rgba(0,168,142,1)]">
                    <span wire:loading.remove>Bayar</span>
                    <span wire:loading>Memproses...</span>
                </button>
            @endif
        </div>
    </div>
</div>
