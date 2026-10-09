<x-filament-widgets::widget>
    <x-filament::section heading="Peta Kamar" description="Ringkasan status seluruh kamar. Klik kamar untuk mengubah.">
        <div class="flex flex-wrap items-center gap-4 pb-4 text-sm">
            <div class="flex items-center gap-2">
                <span class="h-4 w-4 rounded bg-tb-navy"></span>
                Kosong
            </div>
            <div class="flex items-center gap-2">
                <span class="h-4 w-4 rounded bg-gray-200 dark:bg-gray-700"></span>
                Terisi
            </div>
            <div class="flex items-center gap-2">
                <span class="h-4 w-4 rounded bg-warning-300"></span>
                Maintenance
            </div>
        </div>

        @forelse ($groups as $label => $kamars)
            <div @class(['mb-5' => ! $loop->last])>
                @if ($label !== 'Kamar')
                    <p class="mb-2 text-xs font-semibold text-gray-500 dark:text-gray-400">{{ $label }}</p>
                @endif

                <div class="grid grid-cols-4 gap-2 sm:grid-cols-6 lg:grid-cols-10">
                    @foreach ($kamars as $kamar)
                        <a
                            href="{{ route('filament.admin.resources.kamars.edit', $kamar) }}"
                            @class([
                                'flex h-12 items-center justify-center rounded-lg text-sm font-semibold transition hover:opacity-80',
                                'bg-tb-navy text-white' => $kamar->status === 'kosong',
                                'bg-gray-200 text-gray-500 dark:bg-gray-700 dark:text-gray-300' => $kamar->status === 'terisi',
                                'bg-warning-300 text-warning-900' => $kamar->status === 'maintenance',
                            ])
                            title="{{ $kamar->nomor_kamar }} — {{ ucfirst($kamar->status) }}"
                        >
                            {{ $kamar->nomor_kamar }}
                        </a>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada kamar. Tambahkan kamar baru untuk mulai mengisi peta ini.</p>
        @endforelse
    </x-filament::section>
</x-filament-widgets::widget>
