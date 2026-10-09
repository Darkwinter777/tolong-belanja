<?php

namespace App\Filament\Resources\KontrakSewas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class KontrakSewaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kost_kamar_id')
                    ->relationship('kamar', 'nomor_kamar')
                    ->label('Kamar')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('kost_penghuni_id')
                    ->relationship('penghuni', 'nama')
                    ->label('Penghuni')
                    ->searchable()
                    ->preload()
                    ->required(),
                DatePicker::make('tanggal_mulai')
                    ->required(),
                DatePicker::make('tanggal_selesai')
                    ->required(),
                TextInput::make('harga_bulanan')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options(['aktif' => 'Aktif', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'])
                    ->default('aktif')
                    ->required(),
                Textarea::make('catatan')
                    ->columnSpanFull(),
            ]);
    }
}
