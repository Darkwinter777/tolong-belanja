<div>
    @if (! $paid)
        <x-portal.flow-header title="Pembayaran" :subtitle="$this->jumlahTagihan > 0 ? $this->jumlahTagihan.' tagihan menunggu' : null" :back="route('portal.pesanan')" />

        <div class="space-y-4 px-[16px] py-4 pb-32">
            @if ($this->jumlahTagihan === 0)
                <div class="flex flex-col items-center gap-3 rounded-[22px] bg-white p-10 text-center shadow-sm ring-1 ring-black/5">
                    <span class="flex h-14 w-14 shrink-0 basis-14 items-center justify-center rounded-full bg-success-fill text-success-text">
                        @svg('heroicon-o-check-circle', 'h-7 w-7')
                    </span>
                    <div>
                        <p class="text-sm font-semibold text-ink">Tidak ada tagihan</p>
                        <p class="mt-1 text-xs text-text-faint">Semua tagihan Anda sudah lunas.</p>
                    </div>
                </div>
            @else
                <div class="relative overflow-hidden rounded-[24px] bg-navy p-5 text-white">
                    <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full" style="background: rgba(0,168,142,.22);"></div>
                    <p class="relative text-xs text-white/70">Total tagihan</p>
                    <p class="relative mt-1 text-[26px] font-extrabold">Rp {{ number_format($this->total, 0, ',', '.') }}</p>
                    <div class="relative mt-3 flex gap-2">
                        <span class="rounded-full bg-amber-fill px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wide text-amber-text-deep">
                            {{ $this->jumlahTagihan }} Tagihan
                        </span>
                    </div>
                </div>

                <div class="rounded-[22px] bg-white p-4 shadow-sm ring-1 ring-black/5">
                    <p class="mb-3 text-[11px] font-extrabold uppercase tracking-[0.1em] text-text-faint">Rincian</p>
                    <div class="space-y-3">
                        @foreach ($this->outstandingPembayarans as $tagihan)
                            <div class="flex items-center gap-3">
                                <span class="flex h-[38px] w-[38px] shrink-0 basis-[38px] items-center justify-center rounded-xl bg-[#EAF6F3] text-brand-deep">
                                    @svg('heroicon-s-home-modern', 'h-4 w-4')
                                </span>
                                <p class="min-w-0 flex-1 truncate text-sm text-text-secondary">
                                    Sewa Kamar {{ $tagihan->kontrakSewa?->kamar?->nomor_kamar }} — {{ $tagihan->periode_bulan->translatedFormat('M Y') }}
                                </p>
                                <span class="shrink-0 text-sm font-bold text-ink">Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                        @foreach ($this->outstandingTransaksis as $transaksi)
                            <div class="flex items-center gap-3">
                                <span class="flex h-[38px] w-[38px] shrink-0 basis-[38px] items-center justify-center rounded-xl bg-laundry-fill text-laundry-deep">
                                    @svg('heroicon-s-sparkles', 'h-4 w-4')
                                </span>
                                <p class="min-w-0 flex-1 truncate text-sm text-text-secondary">
                                    Laundry {{ $transaksi->order?->kode_order }}
                                </p>
                                <span class="shrink-0 text-sm font-bold text-ink">Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-[22px] bg-white p-4 shadow-sm ring-1 ring-black/5">
                    <p class="mb-3 text-[11px] font-extrabold uppercase tracking-[0.1em] text-text-faint">Metode Pembayaran</p>
                    <div class="space-y-2">
                        @foreach (['BCA Virtual Account' => 'BCA', 'GoPay' => 'GO', 'QRIS' => 'QR', 'Tunai ke pengelola' => 'RP'] as $name => $code)
                            <button
                                type="button"
                                wire:click="pilihMetode('{{ $name }}')"
                                class="flex w-full items-center gap-3 rounded-2xl border-2 p-3 text-left {{ $metode === $name ? 'border-brand' : 'border-[#EEF2F1]' }}"
                            >
                                <span class="flex h-[34px] w-[44px] shrink-0 basis-[44px] items-center justify-center rounded-[10px] bg-field text-[11px] font-extrabold text-text-secondary">{{ $code }}</span>
                                <span class="flex-1 text-sm font-semibold text-ink">{{ $name }}</span>
                                <span @class([
                                    'flex h-5 w-5 shrink-0 basis-5 items-center justify-center rounded-full border-2',
                                    'border-brand bg-brand' => $metode === $name,
                                    'border-border' => $metode !== $name,
                                ]) style="{{ $metode === $name ? 'box-shadow: inset 0 0 0 3px #fff;' : '' }}"></span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        @if ($this->jumlahTagihan > 0)
            <div class="fixed bottom-0 left-1/2 z-30 w-full max-w-md -translate-x-1/2 px-4 pb-[max(1rem,env(safe-area-inset-bottom))]" style="background: linear-gradient(180deg, transparent, rgba(244,247,247,.96) 32%);">
                <div class="flex items-center justify-between rounded-[22px] bg-white p-3 pl-4 shadow-lg ring-1 ring-black/5">
                    <div>
                        <p class="text-[11px] text-text-faint">Bayar dengan {{ $metode }}</p>
                        <p class="text-base font-extrabold text-ink">Rp {{ number_format($this->total, 0, ',', '.') }}</p>
                    </div>
                    <button type="button" wire:click="bayar" wire:loading.attr="disabled" class="flex h-[50px] items-center rounded-2xl bg-brand px-6 text-sm font-extrabold text-white shadow-[0_10px_22px_-12px_rgba(0,168,142,1)]">
                        <span wire:loading.remove>Bayar</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </div>
        @endif
    @else
        <div class="animate-tb-fade flex min-h-screen flex-col items-center px-[22px] pt-[120px] text-center" style="background: #00947C;">
            <div class="flex h-24 w-24 items-center justify-center rounded-full" style="background: rgba(255,255,255,.18);">
                <div class="flex h-[66px] w-[66px] items-center justify-center rounded-full bg-white text-brand-deep">
                    @svg('heroicon-s-check', 'h-8 w-8')
                </div>
            </div>
            <h1 class="mt-6 text-[22px] font-extrabold text-white">Pembayaran berhasil</h1>
            <p class="mt-2 text-sm text-white/85">
                Pembayaran Anda via {{ $metode }} telah kami terima. Bukti pembayaran dikirim ke email Anda.
            </p>

            <div class="mt-6 w-full rounded-[24px] bg-white p-5 text-left">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-text-muted">No. Invoice</span>
                    <span class="font-bold text-ink">{{ $invoiceNo }}</span>
                </div>
                <div class="mt-2 flex items-center justify-between text-sm">
                    <span class="text-text-muted">Waktu</span>
                    <span class="font-bold text-ink">{{ $paidAt }}</span>
                </div>
                <div class="mt-2 flex items-center justify-between text-sm">
                    <span class="text-text-muted">Metode</span>
                    <span class="font-bold text-ink">{{ $metode }}</span>
                </div>
                <div class="my-4 border-t border-dashed border-[#DDE5E4]"></div>
                <a href="{{ route('portal.invoice', ['invoiceNo' => $invoiceNo]) }}" target="_blank" class="flex h-12 w-full items-center justify-center gap-2 rounded-xl border-[1.5px] border-border text-sm font-bold text-ink">
                    @svg('heroicon-o-arrow-down-tray', 'h-4 w-4')
                    Unduh invoice (PDF)
                </a>
            </div>

            <a href="{{ route('portal.pesanan') }}" wire:navigate class="mt-3 flex h-12 w-full items-center justify-center rounded-xl bg-navy text-sm font-bold text-white">
                Lihat pesanan saya
            </a>
        </div>
    @endif
</div>
