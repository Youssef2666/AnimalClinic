<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_date',
        'status'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price_at_purchase')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalPriceAttribute()
    {
        return $this->products->sum(function($product) {
            return $product->pivot->quantity * $product->pivot->price_at_purchase;
        });
    }
}
