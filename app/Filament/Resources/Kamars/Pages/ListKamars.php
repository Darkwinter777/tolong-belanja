<?php

namespace App\Filament\Resources\Kamars\Pages;

use App\Filament\Resources\Kamars\KamarResource;
use App\Filament\Resources\Kamars\Widgets\KamarRoomMapWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKamars extends ListRecords
{
    protected static string $resource = KamarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            KamarRoomMapWidget::class,
        ];
    }
}
