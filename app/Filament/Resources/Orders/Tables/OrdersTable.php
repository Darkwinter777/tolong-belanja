<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Laundry\Models\Order;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_order')
                    ->searchable(),
                TextColumn::make('nama_pelanggan')
                    ->searchable(),
                TextColumn::make('no_hp_pelanggan')
                    ->searchable()
                    ->visibleFrom('md'),
                TextColumn::make('layanan.nama_layanan')
                    ->label('Layanan')
                    ->searchable()
                    ->sortable()
                    ->visibleFrom('md'),
                TextColumn::make('berat_atau_jumlah')
                    ->numeric()
                    ->sortable()
                    ->visibleFrom('lg'),
                TextColumn::make('total_harga')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('estimasi_selesai')
                    ->dateTime()
                    ->sortable()
                    ->visibleFrom('lg'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'diterima' => 'gray',
                        'proses' => 'warning',
                        'selesai' => 'success',
                        'diambil' => 'success',
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
                Action::make('cetak_nota')
                    ->label('Cetak Nota')
                    ->icon('heroicon-o-printer')
                    ->color('gray')
                    ->url(fn (Order $record) => route('laundry.nota', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
