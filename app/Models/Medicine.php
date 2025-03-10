<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medical_record_id',
        'medicine_category_id',
        'description',
    ];

    public function category(){
        return $this->belongsTo(MedicineCategory::class, 'medicine_category_id');
    }

    public function medicalRecord(){
        return $this->belongsTo(MedicalRecord::class, 'medical_record_id');
    }


    public function doctor(){
        return $this->belongsTo(Doctor::class, 'user_id');
    }
}
