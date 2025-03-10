<?php

namespace App\Notifications;

use Ichtrojan\Otp\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class EmailVerificationNotification extends Notification
{
    use Queueable;
    public $message;
    public $subject;
    public $fromEmail;
    public $mailer;
    private $otp;
    public $receiverEmail;
    public function __construct($receiverEmail, $otp)
    {
        $this->message = "استخدم الكود التالي لتفعيل حسابك";
        $this->subject = "تفعيل الحساب";
        $this->fromEmail = 'kingyoussef76@gmail.com';
        $this->mailer = 'smtp';
        $this->otp = $otp;
        $this->receiverEmail = $receiverEmail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $otp = $this->otp->generate($notifiable->email, 'numeric', 6, 60);
        return (new MailMessage)
            ->subject($this->subject)
            ->greeting('أهلا, ' . $notifiable->name)
            ->line($this->message)
            ->line('Code: ' . $otp->token)
            ->markdown('mail.custom_verification', [
                'greeting' => 'أهلا, ' . $notifiable->name,
                'message' => $this->message,
                'code' => $otp->token,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'subject' => $this->subject,
            'fromEmail' => $this->fromEmail,
            'mailer' => $this->mailer,
        ];
    }
}
