<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $message;
    public $subject;
    public $fromEmail;
    public $mailer;
    private $otp;
    public $receiverEmail;
    public function __construct($email,$otp)
    {
        $this->message = "use the below code to reset your password";
        $this->subject = "Paasword Reset";
        $this->fromEmail = 'kingyoussef76@gmail.com';
        $this->mailer = 'smtp';
        $this->otp = $otp;
        Log::info('EmailVerificationNotification constructor');
        $this->receiverEmail = $email;
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
        return (new MailMessage)
                    ->subject($this->subject)
                    ->greeting('Hello, '.$notifiable->name)
                    ->line($this->message)
                    ->line('Code: '.$this->otp);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}