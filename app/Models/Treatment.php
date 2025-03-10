<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'duration',
        'price',
        'product_category_id',
        'vaccination_category_id',
    ];
}
