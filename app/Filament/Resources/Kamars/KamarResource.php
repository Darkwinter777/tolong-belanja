<?php

namespace App\Filament\Resources\Kamars;

use App\Filament\Resources\Concerns\RestrictsToKostModule;
use App\Filament\Resources\Kamars\Pages\CreateKamar;
use App\Filament\Resources\Kamars\Pages\EditKamar;
use App\Filament\Resources\Kamars\Pages\ListKamars;
use App\Filament\Resources\Kamars\Schemas\KamarForm;
use App\Filament\Resources\Kamars\Tables\KamarsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Kost\Models\Kamar;

class KamarResource extends Resource
{
    use RestrictsToKostModule;

    protected static ?string $model = Kamar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Kost';

    public static function form(Schema $schema): Schema
    {
        return KamarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KamarsTable::configure($table);
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
            'index' => ListKamars::route('/'),
            'create' => CreateKamar::route('/create'),
            'edit' => EditKamar::route('/{record}/edit'),
        ];
    }
}
