<x-filament-widgets::widget>
    <div class="rounded-2xl bg-gradient-to-br from-teal-700 to-teal-900 p-6 text-white shadow-sm">
        <p class="text-sm text-teal-100">
            {{ now()->translatedFormat('l, d F Y') }}
        </p>
        <h2 class="mt-1 text-2xl font-bold">
            Halo, {{ auth()->user()?->name }} 👋
        </h2>
        <p class="mt-1 text-teal-100">
            Ini ringkasan bisnis Anda hari ini.
        </p>
    </div>

    @if (count($this->getQuickLinks()))
        <div class="mt-4 grid grid-cols-4 gap-3 sm:grid-cols-7">
            @foreach ($this->getQuickLinks() as $link)
                <a
                    href="{{ $link['url'] }}"
                    class="flex flex-col items-center gap-2 rounded-xl p-2 text-center transition hover:bg-gray-50 dark:hover:bg-white/5"
                >
                    <span class="flex h-12 w-12 shrink-0 basis-12 items-center justify-center rounded-full text-white {{ $link['color'] }}">
                        @svg($link['icon'], 'h-6 w-6')
                    </span>
                    <span class="text-xs font-medium text-gray-700 dark:text-gray-200">
                        {{ $link['label'] }}
                    </span>
                </a>
            @endforeach
        </div>
    @endif
</x-filament-widgets::widget>
