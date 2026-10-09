<?php

namespace App\Filament\Resources\Layanans;

use App\Filament\Resources\Concerns\RestrictsToLaundryModule;
use App\Filament\Resources\Layanans\Pages\CreateLayanan;
use App\Filament\Resources\Layanans\Pages\EditLayanan;
use App\Filament\Resources\Layanans\Pages\ListLayanans;
use App\Filament\Resources\Layanans\Schemas\LayananForm;
use App\Filament\Resources\Layanans\Tables\LayanansTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Laundry\Models\Layanan;

class LayananResource extends Resource
{
    use RestrictsToLaundryModule;

    protected static ?string $model = Layanan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Laundry';

    public static function form(Schema $schema): Schema
    {
        return LayananForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LayanansTable::configure($table);
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
            'index' => ListLayanans::route('/'),
            'create' => CreateLayanan::route('/create'),
            'edit' => EditLayanan::route('/{record}/edit'),
        ];
    }
}
