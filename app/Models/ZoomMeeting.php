<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function animal()
    {
        return $this->hasOneThrough(
            Animal::class,
            Appointment::class,
            'id', // Foreign key on the appointments table
            'id', // Foreign key on the animals table
            'appointment_id', // Local key on the zoom_meetings table
            'animal_id' // Local key on the appointments table
        );
    }

    protected static function booted()
    {
        static::addGlobalScope('doctor_appointments', function (Builder $builder) {
            if (Auth::check()) {
                $user = Auth::user();

                if ($user->role !== 'admin') {
                    $builder->whereHas('appointment', function (Builder $query) use ($user) {
                        $query->where('doctor_id', $user?->doctor?->id);
                    });
                }
            }
        });
    }

}
