<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'meeting_id',
        'start_url',
        'join_url',
        'topic',
        'start_time',
        'duration',
        'timezone',
        'password',
        'agenda',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
