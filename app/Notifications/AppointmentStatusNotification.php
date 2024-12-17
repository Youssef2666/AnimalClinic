<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AppointmentStatusNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $body;
    protected $data;
    protected $fcmToken;
    protected $access_token;
    protected $animal_name;
    protected $status;
    protected $doctor_name;

    public function __construct($title, $body, $data = [], $fcmToken = null, $access_token = null, $animal_name = null, $status = null, $doctor_name = null)
    {
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
        $this->fcmToken = $fcmToken;
        $this->access_token = $access_token;
        $this->animal_name = $animal_name;
        $this->status = $status;
        $this->doctor_name = $doctor_name;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        switch ($this->status) {
            case 'canceled':
                $statusMessage = 'تم إلغاء الموعد';
                break;
            case 'completed':
                $statusMessage = 'تم إتمام الموعد';
                break;
            case 'confirmed':
                $statusMessage = 'تم تأكيد الموعد';
                break;
            default:
                $statusMessage = 'تم تغيير حالة الموعد';
        }

        return (new MailMessage)
            ->subject('تغيير حالة الموعد')
            ->markdown('mail.appointment_status_changed', [
                'greeting' => 'أهلا ' . $notifiable->name . ',',
                'message' => $statusMessage,
                'animal_name' => $this->animal_name,
                'doctor_name' => $this->doctor_name,
                'appointment_id' => $this->data['appointment_id']
            ]);
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'title' => $this->title,
            'body' => $this->body,
            'data' => $this->data,
            'doctor_name' => $this->doctor_name
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
