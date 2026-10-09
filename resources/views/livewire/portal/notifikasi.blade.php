<div>
    <x-portal.flow-header title="Notifikasi" :back="route('portal.home')">
        <x-slot:trailing>
            <button type="button" wire:click="markAllRead" class="shrink-0 text-xs font-bold text-brand">
                Tandai dibaca
            </button>
        </x-slot:trailing>
    </x-portal.flow-header>

    <div class="space-y-[10px] px-[16px] py-4">
        @forelse ($this->notifications as $notification)
            <div @class([
                'rounded-[20px] p-[15px]',
                'bg-white border border-[#E6F4F0]' => is_null($notification->read_at),
                'bg-[#FAFCFB] border border-[#F0F4F3]' => ! is_null($notification->read_at),
            ])>
                <div class="flex items-start gap-2.5">
                    <span @class([
                        'mt-1.5 h-[9px] w-[9px] shrink-0 basis-[9px] rounded-full',
                        'bg-brand' => is_null($notification->read_at),
                        'bg-[#DDE5E4]' => ! is_null($notification->read_at),
                    ])></span>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-baseline justify-between gap-2">
                            <p class="truncate text-sm font-extrabold text-ink">{{ $notification->data['title'] ?? 'Notifikasi' }}</p>
                            <span class="shrink-0 text-[11px] text-text-faint">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="mt-0.5 text-[13px] text-text-secondary">{{ $notification->data['body'] ?? '' }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center gap-3 rounded-[20px] bg-white p-10 text-center shadow-sm ring-1 ring-black/5">
                <span class="flex h-14 w-14 shrink-0 basis-14 items-center justify-center rounded-full bg-field text-text-faint">
                    @svg('heroicon-o-bell', 'h-7 w-7')
                </span>
                <div>
                    <p class="text-sm font-semibold text-ink">Belum ada notifikasi</p>
                    <p class="mt-1 text-xs text-text-faint">Notifikasi order & tagihan akan muncul di sini.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
