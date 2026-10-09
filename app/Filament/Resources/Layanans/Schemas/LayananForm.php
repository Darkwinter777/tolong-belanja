<?php

namespace App\Filament\Resources\Layanans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LayananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_layanan')
                    ->required(),
                Select::make('satuan')
                    ->options(['kg' => 'Kg', 'pcs' => 'Pcs'])
                    ->required(),
                TextInput::make('harga')
                    ->required()
                    ->numeric(),
                Toggle::make('aktif')
                    ->required(),
            ]);
    }
}
