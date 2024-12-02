<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AppointmentStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $title;
    protected $body;
    protected $data;
    protected $fcmToken;
    protected $access_token;

    public function __construct($title, $body, $data = [], $fcmToken = null, $access_token = null)
    {
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
        $this->fcmToken = $fcmToken;
        $this->access_token = $access_token;
        Log::info([
            'title' => $title,
            'fcmToken' => $fcmToken,
            'access_token' => $access_token,
        ]);
    }

    public function toMail($notifiable)
    {
        Log::info('toMail method triggered');
        return (new MailMessage)
            ->subject($this->title)
            ->greeting($this->body)
            ->line('تم تغيير حالة الموعد ')
            ->line('تم تغيير حالة الموعد ');
    }

    public function via($notifiable)
    {
        return ['fcm', 'database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        Log::info('toDatabase method triggered');
        return new DatabaseMessage([
            'title' => $this->title,
            'body' => $this->body,
            'data' => $this->data,
        ]);
    }

    public function toFcm($notifiable)
    {
        Log::info('toFcm method triggered');
        if ($this->fcmToken) {
            Log::info('Sending FCM notification to token: ' . $this->fcmToken);
            Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->access_token,
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/v1/projects/vetcare-c8e34/messages:send', [
                'message' => [
                    'token' => $this->fcmToken,
                    'notification' => [
                        'title' => $this->title,
                        'body' => $this->body,
                    ],
                    'data' => $this->data,
                ],
            ]);
        } else {
            Log::warning('FCM token is missing');
        }
    }
}
