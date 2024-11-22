<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'animal_id',
        'date',
        'time',
        'interview',
        'status',
        'type',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    public function zoomAppointment()
    {
        return $this->hasOne(ZoomMeeting::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('user_appointments', function (Builder $builder) {
            if (Auth::check()) {
                $user = Auth::user();

                if ($user->role !== 'admin') {
                    $builder->where('doctor_id', $user?->doctor?->id);
                }
            }
        });
    }
}
