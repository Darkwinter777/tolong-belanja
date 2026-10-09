<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DashboardHeader extends Widget
{
    protected string $view = 'filament.widgets.dashboard-header';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public static function getSort(): int
    {
        return -10;
    }

    public function getQuickLinks(): array
    {
        $user = auth()->user();
        $links = [];

        if ($user?->can('access kost')) {
            $links[] = ['label' => 'Kamar', 'icon' => 'heroicon-o-home', 'url' => '/admin/kamars', 'color' => 'bg-teal-600'];
            $links[] = ['label' => 'Penghuni', 'icon' => 'heroicon-o-users', 'url' => '/admin/penghunis', 'color' => 'bg-emerald-600'];
            $links[] = ['label' => 'Kontrak', 'icon' => 'heroicon-o-document-text', 'url' => '/admin/kontrak-sewas', 'color' => 'bg-cyan-600'];
            $links[] = ['label' => 'Tagihan', 'icon' => 'heroicon-o-banknotes', 'url' => '/admin/pembayarans', 'color' => 'bg-amber-600'];
        }

        if ($user?->can('access laundry')) {
            $links[] = ['label' => 'Layanan', 'icon' => 'heroicon-o-sparkles', 'url' => '/admin/layanans', 'color' => 'bg-indigo-600'];
            $links[] = ['label' => 'Order', 'icon' => 'heroicon-o-shopping-bag', 'url' => '/admin/orders', 'color' => 'bg-rose-600'];
            $links[] = ['label' => 'Transaksi', 'icon' => 'heroicon-o-credit-card', 'url' => '/admin/transaksis', 'color' => 'bg-violet-600'];
        }

        return $links;
    }
}
