<?php

namespace App\Filament\Resources\KontrakSewas;

use App\Filament\Resources\Concerns\RestrictsToKostModule;
use App\Filament\Resources\KontrakSewas\Pages\CreateKontrakSewa;
use App\Filament\Resources\KontrakSewas\Pages\EditKontrakSewa;
use App\Filament\Resources\KontrakSewas\Pages\ListKontrakSewas;
use App\Filament\Resources\KontrakSewas\Schemas\KontrakSewaForm;
use App\Filament\Resources\KontrakSewas\Tables\KontrakSewasTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Kost\Models\KontrakSewa;

class KontrakSewaResource extends Resource
{
    use RestrictsToKostModule;

    protected static ?string $model = KontrakSewa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Kost';

    protected static ?string $modelLabel = 'Kontrak Sewa';

    public static function form(Schema $schema): Schema
    {
        return KontrakSewaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KontrakSewasTable::configure($table);
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
            'index' => ListKontrakSewas::route('/'),
            'create' => CreateKontrakSewa::route('/create'),
            'edit' => EditKontrakSewa::route('/{record}/edit'),
        ];
    }
}
