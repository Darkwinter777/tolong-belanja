<?php

namespace App\Filament\Resources\KontrakSewas\Pages;

use App\Filament\Resources\KontrakSewas\KontrakSewaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKontrakSewas extends ListRecords
{
    protected static string $resource = KontrakSewaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
