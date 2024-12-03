<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class AppointmentStatusNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $body;
    protected $data;
    protected $fcmToken;
    protected $access_token;
    protected $animal_name;

    public function __construct($title, $body, $data = [], $fcmToken = null, $access_token = null, $animal_name = null)
    {
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
        $this->fcmToken = $fcmToken;
        $this->access_token = $access_token;
        $this->animal_name = $animal_name;
        
        Log::info([
            'title' => $title,
            'fcmToken' => $fcmToken,
            'access_token' => $access_token,
        ]);
    }

    public function via($notifiable)
    {
        return ['fcm','mail', 'database'];
    }

    public function toMail($notifiable)
    {
        Log::info('toMail method triggered');
        return (new MailMessage)
            ->subject('تغيير حالة الموعد')
            ->greeting('أهلا ' . $notifiable->name . ',')
            ->line('تم تغيير حالة الموعد ')
            ->line('الحيوان: ' . $this->animal_name);
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'title' => $this->title,
            'body' => $this->body,
            'data' => $this->data,
        ]);
    }

    // public function toFcm($notifiable)
    // {
    //     if ($this->fcmToken) {
    //         Log::info('Sending FCM notification to token: ' . $this->fcmToken);

    //         return FcmMessage::create()
    //             ->withNotification($this->title, $this->body)
    //             ->withData($this->data)
    //             ->withTarget($this->fcmToken);
    //     } else {
    //         Log::warning('FCM token is missing');
    //     }
    // }


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
