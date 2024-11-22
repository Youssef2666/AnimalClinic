<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorWorkDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'day',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
