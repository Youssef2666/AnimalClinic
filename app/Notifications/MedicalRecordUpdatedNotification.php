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
            ->greeting('أهلا ' . $notifiable->name . ',')
            ->line('تم تحديث سجل حيوانك بنجاح')
            ->line('الحيوان: ' . $this->medicalRecord->animal->name)
            ->line('ملاحظات: ' . $this->medicalRecord->notes)
            ->line('شكرا لك على ثقتك بنا.');
    }
}
