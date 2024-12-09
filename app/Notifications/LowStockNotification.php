<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    private $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('تنبيه انخفاض المخزون')
            ->markdown('mail.low_stock_alert', [
                'greeting' => 'أهلا, ' . $notifiable->name,
                'message' => 'المخزون للمنتج ' . $this->product->name . ' منخفض.',
                'stock' => 'المخزون الحالي: ' . $this->product->stock,
                'action' => 'يرجى إعادة التوريد في أقرب وقت ممكن.'
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'product_id' => $this->product->id,
            'name' => $this->product->name,
            'stock' => $this->product->stock,
        ];
    }
}

