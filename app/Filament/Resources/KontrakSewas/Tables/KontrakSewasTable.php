<?php

namespace App\Filament\Resources\KontrakSewas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KontrakSewasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kamar.nomor_kamar')
                    ->label('Kamar')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('penghuni.nama')
                    ->label('Penghuni')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tanggal_mulai')
                    ->date()
                    ->sortable()
                    ->visibleFrom('md'),
                TextColumn::make('tanggal_selesai')
                    ->date()
                    ->sortable()
                    ->visibleFrom('md'),
                TextColumn::make('harga_bulanan')
                    ->money('IDR')
                    ->sortable()
                    ->visibleFrom('md'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'aktif' => 'success',
                        'selesai' => 'gray',
                        'dibatalkan' => 'danger',
                    }),
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
