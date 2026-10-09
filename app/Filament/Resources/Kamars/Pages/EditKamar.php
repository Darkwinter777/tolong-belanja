<?php

namespace App\Filament\Resources\Kamars\Pages;

use App\Filament\Resources\Kamars\KamarResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKamar extends EditRecord
{
    protected static string $resource = KamarResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
            $this->getCancelFormAction(),
            DeleteAction::make(),
        ];
    }
}
