<div>
    <x-portal.flow-header title="Detail Pesanan" :subtitle="$order->kode_order" :back="route('portal.pesanan')" />

    <div class="space-y-4 px-[16px] py-4 pb-28">
        <div class="rounded-[22px] bg-white p-4 shadow-sm ring-1 ring-black/5">
            <div class="flex items-center gap-3">
                <span class="flex h-[46px] w-[46px] shrink-0 basis-[46px] items-center justify-center rounded-[15px] bg-laundry-fill text-laundry-deep">
                    @svg('heroicon-s-sparkles', 'h-6 w-6')
                </span>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-[15px] font-extrabold text-ink">{{ $order->layanan?->nama_layanan }}</p>
                    <p class="text-xs text-text-muted">{{ $order->berat_atau_jumlah }} {{ $order->layanan?->satuan }}</p>
                </div>
                <span @class([
                    'shrink-0 rounded-full px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wide',
                    'bg-[#EEF2F1] text-text-secondary' => $order->status === 'diterima',
                    'bg-amber-fill text-amber-text' => $order->status === 'proses',
                    'bg-success-fill text-success-text' => in_array($order->status, ['selesai', 'diambil']),
                ])>
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="mt-5 space-y-0">
                @foreach ($this->timeline as $i => $step)
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <span @class([
                                'h-3 w-3 shrink-0 rounded-full',
                                'bg-brand' => $step['done'] || $step['current'],
                                'bg-[#DDE5E4]' => ! $step['done'] && ! $step['current'],
                            ]) style="{{ $step['current'] ? 'box-shadow: 0 0 0 4px rgba(0,168,142,.18);' : '' }}"></span>
                            @if (! $loop->last)
                                <span @class([
                                    'w-[2px] flex-1',
                                    'bg-[#BFE8DE]' => $step['done'],
                                    'bg-[#DDE5E4]' => ! $step['done'],
                                ]) style="min-height: 28px"></span>
                            @endif
                        </div>
                        <div class="pb-5">
                            <p @class([
                                'text-sm',
                                'font-extrabold text-ink' => $step['current'],
                                'font-medium text-ink' => $step['done'] && ! $step['current'],
                                'font-medium text-text-faint' => ! $step['done'] && ! $step['current'],
                            ])>{{ $step['label'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-[22px] bg-white p-4 shadow-sm ring-1 ring-black/5">
            <p class="mb-3 text-[11px] font-extrabold uppercase tracking-[0.1em] text-text-faint">Rincian Biaya</p>
            <div class="flex items-center justify-between text-sm">
                <span class="text-text-secondary">{{ $order->layanan?->nama_layanan }} ({{ $order->berat_atau_jumlah }} {{ $order->layanan?->satuan }})</span>
                <span class="font-bold text-ink">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
            </div>
            <div class="my-3 h-px bg-divider"></div>
            <div class="flex items-center justify-between">
                <span class="text-sm font-extrabold text-ink">Total</span>
                <span class="text-lg font-extrabold text-ink">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    @unless ($this->sudahLunas)
        <div class="fixed bottom-0 left-1/2 z-30 w-full max-w-md -translate-x-1/2 px-4 pb-[max(1rem,env(safe-area-inset-bottom))]" style="background: linear-gradient(180deg, transparent, rgba(244,247,247,.96) 32%);">
            <div class="flex items-center justify-between rounded-[22px] bg-white p-3 pl-4 shadow-lg ring-1 ring-black/5">
                <div>
                    <p class="text-[11px] text-text-faint">Total tagihan</p>
                    <p class="text-base font-extrabold text-ink">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                </div>
                <a href="{{ route('portal.pembayaran') }}" wire:navigate class="flex h-[50px] items-center rounded-2xl bg-brand px-6 text-sm font-extrabold text-white shadow-[0_10px_22px_-12px_rgba(0,168,142,1)]">
                    Bayar
                </a>
            </div>
        </div>
    @endunless
</div>
