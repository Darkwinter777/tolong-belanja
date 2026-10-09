<?php

namespace App\Filament\Resources\Pembayarans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PembayaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kost_kontrak_sewa_id')
                    ->relationship('kontrakSewa', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->kamar?->nomor_kamar} - {$record->penghuni?->nama}")
                    ->label('Kontrak Sewa')
                    ->searchable()
                    ->preload()
                    ->required(),
                DatePicker::make('periode_bulan')
                    ->required(),
                TextInput::make('jumlah_tagihan')
                    ->required()
                    ->numeric(),
                DatePicker::make('tanggal_jatuh_tempo')
                    ->required(),
                DatePicker::make('tanggal_bayar'),
                Select::make('status')
                    ->options(['belum_lunas' => 'Belum lunas', 'lunas' => 'Lunas', 'telat' => 'Telat'])
                    ->default('belum_lunas')
                    ->required(),
                TextInput::make('metode_pembayaran'),
                Textarea::make('catatan')
                    ->columnSpanFull(),
            ]);
    }
}
