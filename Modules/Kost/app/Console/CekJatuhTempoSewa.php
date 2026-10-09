<?php

namespace Modules\Kost\Console;

use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Console\Command;
use Modules\Kost\Models\KontrakSewa;
use Modules\Kost\Models\Pembayaran;

class CekJatuhTempoSewa extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'kost:cek-jatuh-tempo';

    /**
     * The console command description.
     */
    protected $description = 'Cek kontrak sewa yang akan berakhir dan tagihan yang jatuh tempo, lalu kirim reminder.';

    public function handle(): void
    {
        $penerima = User::role(['owner', 'staff'])->get();

        $this->cekKontrakAkanBerakhir($penerima);
        $this->cekTagihanJatuhTempo($penerima);
        $this->tandaiTagihanTelat($penerima);

        $this->info('Pengecekan jatuh tempo selesai.');
    }

    private function cekKontrakAkanBerakhir($penerima): void
    {
        $kontrakAkanBerakhir = KontrakSewa::with(['kamar', 'penghuni'])
            ->where('status', 'aktif')
            ->whereBetween('tanggal_selesai', [now()->toDateString(), now()->addDays(7)->toDateString()])
            ->get();

        foreach ($kontrakAkanBerakhir as $kontrak) {
            $this->line("Kontrak {$kontrak->kamar?->nomor_kamar} - {$kontrak->penghuni?->nama} akan berakhir {$kontrak->tanggal_selesai->format('d/m/Y')}");

            Notification::make()
                ->title('Kontrak sewa akan berakhir')
                ->body("Kamar {$kontrak->kamar?->nomor_kamar} ({$kontrak->penghuni?->nama}) berakhir pada {$kontrak->tanggal_selesai->format('d M Y')}.")
                ->warning()
                ->sendToDatabase($penerima);
        }
    }

    private function cekTagihanJatuhTempo($penerima): void
    {
        $tagihanJatuhTempo = Pembayaran::with(['kontrakSewa.kamar', 'kontrakSewa.penghuni'])
            ->where('status', 'belum_lunas')
            ->whereBetween('tanggal_jatuh_tempo', [now()->toDateString(), now()->addDays(3)->toDateString()])
            ->get();

        foreach ($tagihanJatuhTempo as $tagihan) {
            $kamar = $tagihan->kontrakSewa?->kamar?->nomor_kamar;
            $penghuni = $tagihan->kontrakSewa?->penghuni?->nama;

            $this->line("Tagihan {$kamar} - {$penghuni} jatuh tempo {$tagihan->tanggal_jatuh_tempo->format('d/m/Y')}");

            Notification::make()
                ->title('Tagihan sewa akan jatuh tempo')
                ->body("Tagihan kamar {$kamar} ({$penghuni}) jatuh tempo pada {$tagihan->tanggal_jatuh_tempo->format('d M Y')}.")
                ->warning()
                ->sendToDatabase($penerima);
        }
    }

    private function tandaiTagihanTelat($penerima): void
    {
        $tagihanTelat = Pembayaran::with(['kontrakSewa.kamar', 'kontrakSewa.penghuni'])
            ->where('status', 'belum_lunas')
            ->where('tanggal_jatuh_tempo', '<', now()->toDateString())
            ->get();

        foreach ($tagihanTelat as $tagihan) {
            $tagihan->update(['status' => 'telat']);

            $kamar = $tagihan->kontrakSewa?->kamar?->nomor_kamar;
            $penghuni = $tagihan->kontrakSewa?->penghuni?->nama;

            $this->line("Tagihan {$kamar} - {$penghuni} sudah telat sejak {$tagihan->tanggal_jatuh_tempo->format('d/m/Y')}");

            Notification::make()
                ->title('Tagihan sewa terlambat')
                ->body("Tagihan kamar {$kamar} ({$penghuni}) sudah melewati jatuh tempo ({$tagihan->tanggal_jatuh_tempo->format('d M Y')}).")
                ->danger()
                ->sendToDatabase($penerima);
        }
    }
}
