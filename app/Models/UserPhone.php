<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPhone extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number',
        'verified_at'
    ];

    public function isVerified(): bool
    {
        return !is_null($this->verified_at);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
