<?php

namespace App\Models;

use App\Enums\GenderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'specialization',
        'work_start_time',
        'work_end_time',
        'gender',
    ];

    protected $casts = [
        'gender' => GenderStatus::class,
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}