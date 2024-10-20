<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected static function booted()
    {
        static::addGlobalScope('user_appointments', function (Builder $builder) {
            // Check if the user is authenticated
            if (Auth::check()) {
                $user = Auth::user();

                // Apply the filter based on the role in the users table
                if ($user->role !== 'admin') {
                    // Filter appointments by the logged-in user's ID if the user is not an admin
                    $builder->where('user_id', $user->id);
                }
            }
        });
    }
}
