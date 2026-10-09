<?php

namespace App\Filament\Resources\KontrakSewas\Pages;

use App\Filament\Resources\KontrakSewas\KontrakSewaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKontrakSewa extends EditRecord
{
    protected static string $resource = KontrakSewaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
