<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Modules\Laundry\Models\Order;

class OrderStatusUpdated extends Notification
{
    public function __construct(protected Order $order) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $statusLabel = match ($this->order->status) {
            'diterima' => 'diterima',
            'proses' => 'sedang diproses',
            'selesai' => 'selesai dicuci',
            'diambil' => 'sudah diambil',
            default => $this->order->status,
        };

        return [
            'title' => 'Status order diperbarui',
            'body' => "Order {$this->order->kode_order} sekarang {$statusLabel}.",
            'order_id' => $this->order->id,
        ];
    }
}
