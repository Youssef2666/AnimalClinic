<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surgery extends Model
{
    use HasFactory;

    protected $fillable = [
        'surgery_category_id',
        'user_id',
        'medical_record_id',
        'surgery_date',
        'notes',
    ];

    public function surgeryCategory()
    {
        return $this->belongsTo(SurgeryCategory::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}
