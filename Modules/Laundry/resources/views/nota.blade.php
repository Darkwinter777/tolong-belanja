<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota {{ $order->kode_order }}</title>
    <style>
        * { font-family: 'Courier New', monospace; box-sizing: border-box; }
        body { font-size: 11px; margin: 0; padding: 10px; }
        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 8px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 2px 0; vertical-align: top; }
        .title { font-size: 14px; }
        .small { font-size: 9px; }
    </style>
</head>
<body>
    <div class="center">
        <div class="title bold">PAK TOLONG LAUNDRY</div>
        <div class="small">Nota Pesanan Laundry</div>
    </div>

    <div class="divider"></div>

    <table>
        <tr>
            <td>No. Order</td>
            <td class="right bold">{{ $order->kode_order }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td class="right">{{ $order->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td class="right">{{ $order->nama_pelanggan }}</td>
        </tr>
        @if ($order->no_hp_pelanggan)
            <tr>
                <td>No. HP</td>
                <td class="right">{{ $order->no_hp_pelanggan }}</td>
            </tr>
        @endif
    </table>

    <div class="divider"></div>

    <table>
        <tr class="bold">
            <td>Layanan</td>
            <td class="right">{{ $order->berat_atau_jumlah }} {{ $order->layanan->satuan }}</td>
        </tr>
        <tr>
            <td colspan="2">{{ $order->layanan->nama_layanan }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        <tr class="bold">
            <td>TOTAL</td>
            <td class="right">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td>Estimasi Selesai</td>
        </tr>
        <tr>
            <td class="bold">{{ $order->estimasi_selesai?->format('d/m/Y H:i') ?? '-' }}</td>
        </tr>
        <tr>
            <td>Status</td>
        </tr>
        <tr>
            <td class="bold">{{ ucfirst($order->status) }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="center small">
        Terima kasih telah menggunakan<br>
        jasa laundry kami!
    </div>
</body>
</html>
