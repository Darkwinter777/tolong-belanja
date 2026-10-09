<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TransaksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('laundry_order_id')
                    ->relationship('order', 'kode_order')
                    ->label('Order')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('jumlah_bayar')
                    ->required()
                    ->numeric(),
                TextInput::make('metode_pembayaran'),
                DateTimePicker::make('tanggal_bayar'),
                Select::make('status')
                    ->options(['belum_bayar' => 'Belum bayar', 'lunas' => 'Lunas'])
                    ->default('belum_bayar')
                    ->required(),
            ]);
    }
}
