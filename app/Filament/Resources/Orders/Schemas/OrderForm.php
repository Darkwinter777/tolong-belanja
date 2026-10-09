<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Schemas\Schema;
use Modules\Laundry\Models\Layanan;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_order')
                    ->helperText('Kosongkan untuk generate otomatis')
                    ->disabledOn('edit'),
                TextInput::make('nama_pelanggan')
                    ->required(),
                TextInput::make('no_hp_pelanggan'),
                Select::make('pelanggan_id')
                    ->relationship('pelanggan', 'email')
                    ->label('Akun Portal Pelanggan')
                    ->searchable()
                    ->preload()
                    ->helperText('Hubungkan ke akun login pelanggan (opsional, kosongkan untuk walk-in).'),
                Select::make('laundry_layanan_id')
                    ->relationship('layanan', 'nama_layanan')
                    ->label('Layanan')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $layanan = Layanan::find($get('laundry_layanan_id'));
                        $set('total_harga', $layanan && $get('berat_atau_jumlah')
                            ? $layanan->harga * $get('berat_atau_jumlah')
                            : null);
                    }),
                TextInput::make('berat_atau_jumlah')
                    ->required()
                    ->numeric()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $layanan = Layanan::find($get('laundry_layanan_id'));
                        $set('total_harga', $layanan && $get('berat_atau_jumlah')
                            ? $layanan->harga * $get('berat_atau_jumlah')
                            : null);
                    }),
                TextInput::make('total_harga')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('estimasi_selesai'),
                Select::make('status')
                    ->options(['diterima' => 'Diterima', 'proses' => 'Proses', 'selesai' => 'Selesai', 'diambil' => 'Diambil'])
                    ->default('diterima')
                    ->required(),
                Textarea::make('catatan')
                    ->columnSpanFull(),
            ]);
    }
}
