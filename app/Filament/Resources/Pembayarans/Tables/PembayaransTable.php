<?php

namespace App\Filament\Resources\Pembayarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PembayaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kontrakSewa.kamar.nomor_kamar')
                    ->label('Kamar')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kontrakSewa.penghuni.nama')
                    ->label('Penghuni')
                    ->searchable()
                    ->sortable()
                    ->visibleFrom('md'),
                TextColumn::make('periode_bulan')
                    ->date('F Y')
                    ->sortable()
                    ->visibleFrom('md'),
                TextColumn::make('jumlah_tagihan')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('tanggal_jatuh_tempo')
                    ->date()
                    ->sortable()
                    ->visibleFrom('lg'),
                TextColumn::make('tanggal_bayar')
                    ->date()
                    ->sortable()
                    ->visibleFrom('lg'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'lunas' => 'success',
                        'belum_lunas' => 'warning',
                        'telat' => 'danger',
                    }),
                TextColumn::make('metode_pembayaran')
                    ->searchable()
                    ->visibleFrom('md'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
