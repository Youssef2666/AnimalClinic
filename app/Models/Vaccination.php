<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;

    protected $fillable = [
        'vaccination_category_id',
        'user_id',
        'medical_record_id',
        'vaccination_date',
        'notes',
    ];

    public function vaccinationCategory()
    {
        return $this->belongsTo(VaccinationCategory::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'user_id');
    }

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}
