<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_id',
        'notes',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function surgeries(){
        return $this->hasMany(Surgery::class);
    }

    public function vaccinations(){
        return $this->hasMany(Vaccination::class);
    }
}