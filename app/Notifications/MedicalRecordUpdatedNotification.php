<?php

namespace App\Notifications;

use App\Models\MedicalRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class MedicalRecordUpdatedNotification extends Notification
{
    use Queueable;

    protected $medicalRecord;
    protected $doctor_name;

    public function __construct(MedicalRecord $medicalRecord, $doctor_name = null)
    {
        $this->medicalRecord = $medicalRecord;
        $this->doctor_name = $doctor_name;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('تحديث سجل طبي')
            ->markdown('mail.medical_record_updated', [
                'greeting' => 'أهلا ' . $notifiable->name . ',',
                'message' => 'تم تحديث سجل حيوانك بنجاح',
                'animal_name' => $this->medicalRecord->animal->name,
                'doctor_name' => $this->doctor_name
        ]);
    }

    public function toDatabase($notifiable){
        return new DatabaseMessage([
            'title' => 'تحديث سجل طبي',
            'body' => 'تم تحديث سجل حيوانك بنجاح',
            'data' => $this->medicalRecord,
            'doctor_name' => $this->doctor_name
        ]);
    }
    
}
