<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'user_id',
        'animal_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(AnimalCategory::class, 'animal_type');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
