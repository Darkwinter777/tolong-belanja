<?php

namespace App\Filament\Resources\Concerns;

use Illuminate\Database\Eloquent\Model;

trait RestrictsToKostModule
{
    public static function canAccess(): bool
    {
        return auth()->user()?->can('access kost') ?? false;
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->can('delete data') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete data') ?? false;
    }
}
