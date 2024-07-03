<?php

namespace App\Models;

use App\Enums\GenderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'gender',
    ];

    protected $casts = [
        'gender' => GenderStatus::class,
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

}
