<?php

namespace App\Notifications;

use App\Models\MedicalRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MedicalRecordUpdatedNotification extends Notification
{
    use Queueable;

    protected $medicalRecord;

    public function __construct(MedicalRecord $medicalRecord)
    {
        $this->medicalRecord = $medicalRecord;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('تحديث سجل طبي')
            ->markdown('mail.medical_record_updated', [
                'greeting' => 'أهلا ' . $notifiable->name . ',',
                'message' => 'تم تحديث سجل حيوانك بنجاح',
                'animal_name' => $this->medicalRecord->animal->name,
        ]);
    }
}
