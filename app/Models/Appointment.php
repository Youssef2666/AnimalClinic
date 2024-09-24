<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'animal_id',
        'date',
        'time',
        'interview',
        'status',
        'type',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'user_id');
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    public function zoomAppointment()
    {
        return $this->hasOne(ZoomMeeting::class);
    }
}
