<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $title ?? 'Tolong Belanja' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @include('pwa.portal-head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-200 text-ink antialiased">
    <div class="mx-auto flex min-h-screen max-w-md flex-col bg-bg shadow-2xl">
        <main class="flex-1 overflow-y-auto {{ ($showNav ?? true) ? 'pb-20' : 'pb-6' }}">
            {{ $slot }}
        </main>

        @auth('pelanggan')
            @if ($showNav ?? true)
                <nav class="fixed bottom-0 left-1/2 z-40 w-full max-w-md -translate-x-1/2 border-t border-divider bg-white/95 px-2 pb-[max(0.375rem,env(safe-area-inset-bottom))] pt-1.5 backdrop-blur">
                    <div class="grid grid-cols-3 gap-1">
                        @php
                            $navItems = [
                                ['label' => 'Home', 'icon' => 'home', 'route' => 'portal.home'],
                                ['label' => 'Langganan', 'icon' => 'clipboard-document-list', 'route' => 'portal.pesanan', 'routes' => ['portal.pesanan', 'portal.kost', 'portal.laundry']],
                                ['label' => 'Profil', 'icon' => 'user-circle', 'route' => 'portal.profile'],
                            ];
                        @endphp
                        @foreach ($navItems as $item)
                            @php $isActive = request()->routeIs(...($item['routes'] ?? [$item['route']])); @endphp
                            <a
                                href="{{ route($item['route']) }}"
                                wire:navigate
                                class="flex flex-col items-center gap-0.5 rounded-xl py-1 text-[10px] font-medium transition {{ $isActive ? 'text-brand-deep' : 'text-text-faint' }}"
                            >
                                @svg('heroicon-'.($isActive ? 's' : 'o').'-'.$item['icon'], 'h-5 w-5')
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>
                </nav>
            @endif
        @endauth
    </div>

    @livewireScripts
    @include('pwa.portal-body')
</body>
</html>
