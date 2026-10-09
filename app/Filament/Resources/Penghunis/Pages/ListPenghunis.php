<?php

namespace App\Filament\Resources\Penghunis\Pages;

use App\Filament\Resources\Penghunis\PenghuniResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPenghunis extends ListRecords
{
    protected static string $resource = PenghuniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
