<div>
    <x-portal.flow-header title="Laundry Saya" subtitle="Riwayat & status order Anda" :back="route('portal.home')" />

    <div class="space-y-4 px-4 py-4 lg:grid lg:grid-cols-2 lg:items-start lg:gap-4 lg:space-y-0 lg:px-8">
        @forelse ($this->orders as $order)
            <a href="{{ route('portal.laundry.detail', $order) }}" wire:navigate class="block rounded-[22px] bg-white p-4 shadow-sm ring-1 ring-black/5">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <span class="flex h-11 w-11 shrink-0 basis-11 items-center justify-center rounded-xl bg-laundry-fill text-laundry-deep">
                            @svg('heroicon-s-sparkles', 'h-6 w-6')
                        </span>
                        <div>
                            <p class="font-extrabold text-ink">{{ $order->kode_order }}</p>
                            <p class="text-xs text-text-muted">{{ $order->layanan?->nama_layanan }}</p>
                        </div>
                    </div>
                    <span @class([
                        'shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold',
                        'bg-[#EEF2F1] text-text-secondary' => $order->status === 'diterima',
                        'bg-amber-fill text-amber-text' => $order->status === 'proses',
                        'bg-success-fill text-success-text' => in_array($order->status, ['selesai', 'diambil']),
                    ])>
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="mt-3 flex items-center justify-between border-t border-divider-soft pt-3 text-sm">
                    <span class="text-text-muted">{{ $order->berat_atau_jumlah }} {{ $order->layanan?->satuan }}</span>
                    <span class="font-bold text-ink">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>

                @if ($order->estimasi_selesai)
                    <p class="mt-2 flex items-center gap-1 text-xs text-text-faint">
                        @svg('heroicon-o-clock', 'h-3.5 w-3.5')
                        Estimasi selesai: {{ $order->estimasi_selesai->format('d M Y H:i') }}
                    </p>
                @endif
            </a>
        @empty
            <div class="flex flex-col items-center gap-3 rounded-[22px] bg-white p-10 lg:col-span-2 text-center shadow-sm ring-1 ring-black/5">
                <span class="flex h-14 w-14 shrink-0 basis-14 items-center justify-center rounded-full bg-laundry-fill text-laundry-deep">
                    @svg('heroicon-o-sparkles', 'h-7 w-7')
                </span>
                <div>
                    <p class="text-sm font-semibold text-ink">Belum ada order laundry</p>
                    <p class="mt-1 text-xs text-text-faint">Yuk order laundry pertama Anda.</p>
                </div>
                <a href="{{ route('portal.laundry.book') }}" wire:navigate class="mt-1 rounded-xl bg-laundry-deep px-4 py-2 text-sm font-bold text-white">
                    Order Laundry
                </a>
            </div>
        @endforelse
    </div>
</div>
