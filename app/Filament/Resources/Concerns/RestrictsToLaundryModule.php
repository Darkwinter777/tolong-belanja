<?php

namespace App\Filament\Resources\Concerns;

use Illuminate\Database\Eloquent\Model;

trait RestrictsToLaundryModule
{
    public static function canAccess(): bool
    {
        return auth()->user()?->can('access laundry') ?? false;
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
