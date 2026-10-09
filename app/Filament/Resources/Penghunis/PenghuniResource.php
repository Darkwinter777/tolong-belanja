<?php

namespace App\Filament\Resources\Penghunis;

use App\Filament\Resources\Concerns\RestrictsToKostModule;
use App\Filament\Resources\Penghunis\Pages\CreatePenghuni;
use App\Filament\Resources\Penghunis\Pages\EditPenghuni;
use App\Filament\Resources\Penghunis\Pages\ListPenghunis;
use App\Filament\Resources\Penghunis\Schemas\PenghuniForm;
use App\Filament\Resources\Penghunis\Tables\PenghunisTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Kost\Models\Penghuni;

class PenghuniResource extends Resource
{
    use RestrictsToKostModule;

    protected static ?string $model = Penghuni::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Kost';

    public static function form(Schema $schema): Schema
    {
        return PenghuniForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PenghunisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenghunis::route('/'),
            'create' => CreatePenghuni::route('/create'),
            'edit' => EditPenghuni::route('/{record}/edit'),
        ];
    }
}
