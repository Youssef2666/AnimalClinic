<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surgery extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'surgery_category_id',
        'doctor_id',
        'surgery_date',
        'notes',
        'notes',
    ];
}
