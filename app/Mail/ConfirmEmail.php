<?php

namespace App\Mail;

use Ichtrojan\Otp\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;
use PgSql\Lob;

class ConfirmEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailMessage;
    public $subject;
    private $otp;
    public $potp;
    public function __construct()
    {
        $this->mailMessage = 'Use the below code to verify your email';
        $this->subject = 'Email Verification';
        $this->otp = new Otp;
        try{
        $this->potp = $this->otp->generate('youssefalmerash76@gmail.com','numeric',6,60);
        Log::info($this->potp->token);
        }catch(\Exception $e){
            Log::info($e->getMessage());
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        Log::info('ConfirmEmail envelope');
        return new Envelope(
            from: new Address('kingyoussef76@gmail.com', 'King Youssef'),
            replyTo: [
                new Address('youssefalmerash76@gmail.com', 'Normal Person'),
            ],
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}