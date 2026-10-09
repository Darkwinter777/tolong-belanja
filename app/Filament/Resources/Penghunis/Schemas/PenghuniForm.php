<?php

namespace App\Filament\Resources\Penghunis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PenghuniForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                Select::make('pelanggan_id')
                    ->relationship('pelanggan', 'email')
                    ->label('Akun Portal Pelanggan')
                    ->searchable()
                    ->preload()
                    ->helperText('Hubungkan ke akun login pelanggan (opsional).'),
                TextInput::make('no_hp'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('no_ktp'),
                DatePicker::make('tanggal_masuk'),
                Textarea::make('alamat_asal')
                    ->columnSpanFull(),
            ]);
    }
}
