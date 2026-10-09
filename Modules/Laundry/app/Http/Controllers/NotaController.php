<?php

namespace Modules\Laundry\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Laundry\Models\Order;

class NotaController extends Controller
{
    public function show(Order $order): Response
    {
        $order->load('layanan', 'transaksis');

        $pdf = Pdf::loadView('laundry::nota', ['order' => $order])
            ->setPaper([0, 0, 226.77, 566.93], 'portrait');

        return $pdf->stream("nota-{$order->kode_order}.pdf");
    }
}
