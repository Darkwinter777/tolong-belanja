<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $invoiceNo }}</title>
    <style>
        * { font-family: Arial, sans-serif; box-sizing: border-box; }
        body { font-size: 12px; margin: 0; padding: 24px; color: #0F1B1A; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }
        .brand { font-size: 18px; font-weight: 800; color: #00806C; }
        .muted { color: #6B7B7A; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th { text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.06em; color: #6B7B7A; border-bottom: 1px solid #E2EAE9; padding-bottom: 8px; }
        td { padding: 10px 0; border-bottom: 1px solid #EEF2F1; }
        .right { text-align: right; }
        .total-row td { border: 0; padding-top: 16px; font-size: 16px; font-weight: 800; }
        .badge { display: inline-block; background: #DFF5EC; color: #0A7D5F; padding: 4px 10px; border-radius: 999px; font-size: 10px; font-weight: 700; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="brand">Tolong Belanja</div>
            <div class="muted">Invoice Pembayaran</div>
        </div>
        <div style="text-align:right;">
            <div><strong>{{ $invoiceNo }}</strong></div>
            <div class="muted">{{ now()->translatedFormat('d M Y, H:i') }}</div>
            <span class="badge">LUNAS</span>
        </div>
    </div>

    <div class="muted">Ditagihkan kepada</div>
    <div><strong>{{ $pelanggan->nama }}</strong></div>
    <div class="muted">{{ $pelanggan->email }}</div>

    <table>
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th class="right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembayarans as $p)
                <tr>
                    <td>Sewa Kamar {{ $p->kontrakSewa?->kamar?->nomor_kamar }} — {{ $p->periode_bulan->translatedFormat('F Y') }}</td>
                    <td class="right">Rp {{ number_format($p->jumlah_tagihan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            @foreach ($transaksis as $t)
                <tr>
                    <td>Laundry {{ $t->order?->kode_order }}</td>
                    <td class="right">Rp {{ number_format($t->jumlah_bayar, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td>Total</td>
                <td class="right">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <p class="muted" style="margin-top: 32px; text-align: center;">Terima kasih telah menggunakan layanan Tolong Belanja.</p>
</body>
</html>
