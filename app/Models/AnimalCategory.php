<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
    ];

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
}
