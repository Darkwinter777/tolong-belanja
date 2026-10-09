<?php

namespace App\Filament\Resources\Kamars\Widgets;

use Filament\Widgets\Widget;
use Modules\Kost\Models\Kamar;

class KamarRoomMapWidget extends Widget
{
    protected static bool $isLazy = false;

    protected string $view = 'filament.resources.kamars.widgets.kamar-room-map-widget';

    protected int|string|array $columnSpan = 'full';

    protected function getKamars()
    {
        return Kamar::query()
            ->orderBy('nomor_kamar')
            ->get()
            ->groupBy(function (Kamar $kamar) {
                return rtrim(preg_replace('/[0-9]+$/', '', $kamar->nomor_kamar)) ?: 'Kamar';
            });
    }

    protected function getViewData(): array
    {
        return [
            'groups' => $this->getKamars(),
        ];
    }
}
