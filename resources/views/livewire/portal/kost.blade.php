<div>
    <x-portal.flow-header title="Kost Saya" subtitle="Kontrak sewa & tagihan Anda" :back="route('portal.home')" />

    <div class="space-y-4 px-4 py-4">
        @forelse ($this->kontrakSewas as $kontrak)
            <div class="rounded-[22px] bg-white p-4 shadow-sm ring-1 ring-black/5">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <span class="flex h-11 w-11 shrink-0 basis-11 items-center justify-center rounded-xl bg-[#EAF6F3] text-brand-deep">
                            @svg('heroicon-s-home-modern', 'h-6 w-6')
                        </span>
                        <div>
                            <p class="font-extrabold text-ink">Kamar {{ $kontrak->kamar?->nomor_kamar }}</p>
                            <p class="text-xs text-text-muted">
                                {{ $kontrak->tanggal_mulai->format('d M Y') }} &mdash; {{ $kontrak->tanggal_selesai->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                    <span @class([
                        'shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold',
                        'bg-success-fill text-success-text' => $kontrak->status === 'aktif',
                        'bg-[#EEF2F1] text-text-secondary' => $kontrak->status === 'selesai',
                        'bg-laundry-fill text-laundry-deep' => $kontrak->status === 'dibatalkan',
                    ])>
                        {{ ucfirst($kontrak->status) }}
                    </span>
                </div>

                <p class="mt-3 text-sm font-semibold text-text-secondary">
                    Rp {{ number_format($kontrak->harga_bulanan, 0, ',', '.') }} <span class="font-normal text-text-faint">/ bulan</span>
                </p>

                @if ($kontrak->pembayarans->isNotEmpty())
                    <div class="mt-3 space-y-2 border-t border-divider-soft pt-3">
                        <p class="text-xs font-bold text-text-faint">Riwayat Tagihan</p>
                        @foreach ($kontrak->pembayarans->sortByDesc('periode_bulan') as $tagihan)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-text-secondary">{{ $tagihan->periode_bulan->translatedFormat('F Y') }}</span>
                                <span @class([
                                    'rounded-full px-2 py-0.5 text-xs font-semibold',
                                    'bg-success-fill text-success-text' => $tagihan->status === 'lunas',
                                    'bg-amber-fill text-amber-text' => $tagihan->status === 'belum_lunas',
                                    'bg-laundry-fill text-laundry-deep' => $tagihan->status === 'telat',
                                ])>
                                    {{ $tagihan->status === 'belum_lunas' ? 'Belum Lunas' : ucfirst($tagihan->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="flex flex-col items-center gap-3 rounded-[22px] bg-white p-10 text-center shadow-sm ring-1 ring-black/5">
                <span class="flex h-14 w-14 shrink-0 basis-14 items-center justify-center rounded-full bg-[#EAF6F3] text-brand-deep">
                    @svg('heroicon-o-home-modern', 'h-7 w-7')
                </span>
                <div>
                    <p class="text-sm font-semibold text-ink">Belum ada data kost</p>
                    <p class="mt-1 text-xs text-text-faint">Yuk booking kamar pertama Anda.</p>
                </div>
                <a href="{{ route('portal.kost.book') }}" wire:navigate class="mt-1 rounded-xl bg-brand px-4 py-2 text-sm font-bold text-white">
                    Booking Kamar
                </a>
            </div>
        @endforelse
    </div>
</div>
