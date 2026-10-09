<?php

namespace App\Filament\Resources\Kamars\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class KamarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nomor_kamar')
                    ->required(),
                TextInput::make('tipe'),
                TextInput::make('harga')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options(['kosong' => 'Kosong', 'terisi' => 'Terisi', 'maintenance' => 'Maintenance'])
                    ->default('kosong')
                    ->required(),
                Textarea::make('keterangan')
                    ->columnSpanFull(),
                FileUpload::make('foto_kamar')
                    ->label('Foto Kondisi Kamar')
                    ->image()
                    ->multiple()
                    ->maxFiles(10)
                    ->reorderable()
                    ->appendFiles()
                    ->disk('public')
                    ->directory('kamar-photos')
                    ->imageEditor()
                    ->imagePreviewHeight('120')
                    ->saveUploadedFileUsing(fn (TemporaryUploadedFile $file): string => static::storeResized($file))
                    ->columnSpanFull(),
            ]);
    }

    protected static function storeResized(TemporaryUploadedFile $file): string
    {
        $maxDimension = 1600;
        $quality = 82;

        [$width, $height, $type] = getimagesize($file->getRealPath());

        $source = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($file->getRealPath()),
            IMAGETYPE_PNG => imagecreatefrompng($file->getRealPath()),
            IMAGETYPE_WEBP => imagecreatefromwebp($file->getRealPath()),
            IMAGETYPE_GIF => imagecreatefromgif($file->getRealPath()),
            default => null,
        };

        if (! $source) {
            $path = 'kamar-photos/'.Str::ulid().'.'.$file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('kamar-photos', $file, basename($path));

            return $path;
        }

        // Correct orientation for photos taken on phones (EXIF rotation).
        if ($type === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
            $exif = @exif_read_data($file->getRealPath());
            $orientation = $exif['Orientation'] ?? 1;

            $source = match ($orientation) {
                3 => imagerotate($source, 180, 0),
                6 => imagerotate($source, -90, 0),
                8 => imagerotate($source, 90, 0),
                default => $source,
            };

            $width = imagesx($source);
            $height = imagesy($source);
        }

        $scale = min(1, $maxDimension / max($width, $height));
        $newWidth = (int) round($width * $scale);
        $newHeight = (int) round($height * $scale);

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($source);

        ob_start();
        imagejpeg($resized, null, $quality);
        $contents = ob_get_clean();
        imagedestroy($resized);

        $path = 'kamar-photos/'.Str::ulid().'.jpg';
        Storage::disk('public')->put($path, $contents);

        return $path;
    }
}
