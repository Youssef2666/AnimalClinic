<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class OrderStatusChangedNotification extends Notification
{
    use Queueable;

    private $title = 'تم تغيير حالة الطلب';
    private $body = 'تم تغيير حالة الطلب الى';
    private $data = [];
    public function __construct(private $order)
    {
        if($this->order->status == 'canceled'){
            $this->title = 'تم الغاء الطلب';
            $this->body = 'تم الغاء طلبك بنجاح';
        } else if($this->order->status == 'delivered'){
            $this->title = 'تم تسليم الطلب';
            $this->body = 'تم تسليم طلبك بنجاح';
        } else if($this->order->status == 'confirmed'){
            $this->title = 'تم تأكيد الطلب';
            $this->body = 'تم تأكيد طلبك بنجاح';
        }
        $this->data = [
            'order_id' => $this->order->id,
            'order_status' => $this->order->status,
            'created_at' => now()->toDateTimeString(),
        ];
        $this->body .= $this->order->status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('تم تغيير حالة الطلب')
            ->greeting('أهلا ' . $notifiable->name . ',')
            ->line('تم تغيير حالة الطلب الى ' . $this->order->status)
            ->line('رقم الطلب: ' . $this->order->id);
    }
     public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'title' => $this->title,
            'body' => $this->body,
            'data' => $this->data,
        ]);
    }
    public function toArray(object $notifiable): array
    {
        return [
            'subject' => 'تم تغيير حالة الطلب',
            'greeting' => 'أهلا ' . $notifiable->name . ',',
            'message' => [
                'line1' => 'تم تغيير حالة الطلب الى ' . $this->order->status,
                'line2' => 'رقم الطلب: ' . $this->order->id,
            ],
            'order_id' => $this->order->id,
            'order_status' => $this->order->status,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
