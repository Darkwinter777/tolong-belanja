<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\Kost\Models\Kamar;
use Modules\Kost\Models\KontrakSewa;
use Modules\Kost\Models\Pembayaran;
use Modules\Kost\Models\Penghuni;

#[Layout('portal.layouts.app', ['showNav' => false, 'narrow' => true])]
class KostBooking extends Component
{
    public int $step = 1;

    public ?int $kamarId = null;

    public int $dateOffset = 3;

    public int $durasiBulan = 3;

    public string $catatan = '';

    public function mount(): void
    {
        $first = Kamar::where('status', 'kosong')->orderBy('harga')->skip(1)->first()
            ?? Kamar::where('status', 'kosong')->first();

        $this->kamarId = $first?->id;
    }

    public function getKamarsProperty()
    {
        return Kamar::where('status', 'kosong')->orderBy('harga')->get();
    }

    public function getKamarProperty(): ?Kamar
    {
        return Kamar::find($this->kamarId);
    }

    public function getDateOptionsProperty(): array
    {
        return collect(range(0, 3))->map(fn ($i) => now()->addDays($i))->toArray();
    }

    public function getTanggalMulaiProperty()
    {
        return now()->addDays($this->dateOffset)->startOfDay();
    }

    public function getBiayaProperty(): array
    {
        $harga = $this->kamar?->harga ?? 0;
        $sewa = $harga * $this->durasiBulan;
        $deposit = 300000;
        $admin = 15000;

        return [
            'sewa' => $sewa,
            'deposit' => $deposit,
            'admin' => $admin,
            'total' => $sewa + $deposit + $admin,
        ];
    }

    public function pilihKamar(int $kamarId): void
    {
        $this->kamarId = $kamarId;
    }

    public function nextStep(): void
    {
        if ($this->step === 1 && ! $this->kamarId) {
            return;
        }

        $this->step = min(3, $this->step + 1);
    }

    public function prevStep(): void
    {
        $this->step = max(1, $this->step - 1);
    }

    public function submit(): void
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        $kamar = $this->kamar;

        if (! $kamar || $kamar->status !== 'kosong') {
            $this->addError('kamarId', 'Kamar ini sudah tidak tersedia.');
            $this->step = 1;

            return;
        }

        DB::transaction(function () use ($pelanggan, $kamar) {
            $penghuni = $pelanggan->penghunis()->first() ?? Penghuni::create([
                'pelanggan_id' => $pelanggan->id,
                'nama' => $pelanggan->nama,
                'no_hp' => $pelanggan->no_hp,
                'email' => $pelanggan->email,
                'tanggal_masuk' => $this->tanggalMulai,
            ]);

            $kontrak = KontrakSewa::create([
                'kost_kamar_id' => $kamar->id,
                'kost_penghuni_id' => $penghuni->id,
                'tanggal_mulai' => $this->tanggalMulai,
                'tanggal_selesai' => $this->tanggalMulai->copy()->addMonths($this->durasiBulan),
                'harga_bulanan' => $kamar->harga,
                'status' => 'aktif',
                'catatan' => $this->catatan ?: null,
            ]);

            Pembayaran::create([
                'kost_kontrak_sewa_id' => $kontrak->id,
                'periode_bulan' => $this->tanggalMulai->copy()->startOfMonth(),
                'jumlah_tagihan' => $this->biaya['total'],
                'tanggal_jatuh_tempo' => $this->tanggalMulai,
                'status' => 'belum_lunas',
                'catatan' => 'Sewa bulan pertama + deposit + admin (booking mandiri)',
            ]);

            $kamar->update(['status' => 'terisi']);
        });

        $this->redirectRoute('portal.pembayaran', navigate: true);
    }

    public function render()
    {
        return view('livewire.portal.kost-booking');
    }
}
