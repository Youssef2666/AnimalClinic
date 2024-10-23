<?php

namespace App\Models;

use App\Models\MedicalRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'age',
        'weight',
        'animal_type',
        'animal_category_id',
        'gender'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(AnimalCategory::class, 'animal_category_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function zoomAppointment(){
        return $this->hasManyThrough(ZoomMeeting::class, Appointment::class);
    }

    public function medicalRecord(){
        return $this->hasOne(MedicalRecord::class);
    }
}