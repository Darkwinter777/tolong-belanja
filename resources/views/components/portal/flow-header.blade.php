@props(['back' => null, 'title', 'subtitle' => null])

<div class="sticky top-0 z-20 border-b border-divider bg-white px-[22px] pb-4 pt-[62px]">
    <div class="flex items-center gap-3">
        @if ($back)
            <a href="{{ $back }}" wire:navigate class="flex h-10 w-10 shrink-0 basis-10 items-center justify-center rounded-[13px] bg-field text-ink">
                @svg('heroicon-o-arrow-left', 'h-5 w-5')
            </a>
        @else
            <button type="button" onclick="history.back()" class="flex h-10 w-10 shrink-0 basis-10 items-center justify-center rounded-[13px] bg-field text-ink">
                @svg('heroicon-o-arrow-left', 'h-5 w-5')
            </button>
        @endif

        <div class="min-w-0 flex-1">
            <h1 class="truncate text-base font-extrabold text-ink">{{ $title }}</h1>
            @if ($subtitle)
                <p class="truncate text-xs text-text-muted">{{ $subtitle }}</p>
            @endif
        </div>

        {{ $trailing ?? '' }}
    </div>
</div>
