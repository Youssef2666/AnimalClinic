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
            ->subject('Low Stock Alert')
            ->line('The stock for ' . $this->product->name . ' is low.')
            ->line('Current stock: ' . $this->product->stock)
            ->line('Please restock as soon as possible.');
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
