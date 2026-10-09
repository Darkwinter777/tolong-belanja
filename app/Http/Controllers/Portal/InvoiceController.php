<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Kost\Models\Pembayaran as KostPembayaran;
use Modules\Laundry\Models\Transaksi;

class InvoiceController extends Controller
{
    public function show(Request $request): Response
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        $kontrakIds = $pelanggan->penghunis()
            ->with('kontrakSewas')
            ->get()
            ->pluck('kontrakSewas')
            ->flatten()
            ->pluck('id');

        $pembayarans = $kontrakIds->isEmpty()
            ? collect()
            : KostPembayaran::whereIn('kost_kontrak_sewa_id', $kontrakIds)
                ->where('status', 'lunas')
                ->whereDate('tanggal_bayar', today())
                ->with('kontrakSewa.kamar')
                ->get();

        $orderIds = $pelanggan->orders()->pluck('id');

        $transaksis = $orderIds->isEmpty()
            ? collect()
            : Transaksi::whereIn('laundry_order_id', $orderIds)
                ->where('status', 'lunas')
                ->whereDate('tanggal_bayar', today())
                ->with('order')
                ->get();

        $invoiceNo = $request->query('invoiceNo', 'INV/'.now()->format('Y/m/d'));
        $total = $pembayarans->sum('jumlah_tagihan') + $transaksis->sum('jumlah_bayar');

        $pdf = Pdf::loadView('portal.invoice', [
            'pelanggan' => $pelanggan,
            'pembayarans' => $pembayarans,
            'transaksis' => $transaksis,
            'invoiceNo' => $invoiceNo,
            'total' => $total,
        ])->setPaper('a5', 'portrait');

        $filename = str_replace(['/', '\\'], '-', $invoiceNo).'.pdf';

        return $pdf->stream($filename);
    }
}
