<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Support\Facades\Http;

class AppointmentStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $title;
    protected $body;
    protected $data;
    protected $fcmToken;

    public function __construct($title, $body, $data = [], $fcmToken = null)
    {
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
        $this->fcmToken = $fcmToken;
    }

    public function via($notifiable)
    {
        return ['database', 'fcm'];
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'title' => $this->title,
            'body' => $this->body,
            'data' => $this->data,
        ]);
    }

    public function toFcm($notifiable)
    {
        if ($this->fcmToken) {
            Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.fcm.access_token'), // Assuming access_token is set in config/services.php
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
        }
    }
}

