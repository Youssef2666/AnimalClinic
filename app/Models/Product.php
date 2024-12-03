<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\LowStockNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_category_id',
        'price',
        'stock',
        'description',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price_at_purchase')->withTimestamps();
    }

    public function favouritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorite_products');
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($product) {
    //         $lowStockThreshold = 5;

    //         if ($product->stock > 0 && $product->stock <= $lowStockThreshold) {
    //             // Notify the admin(s)
    //             $admins = User::where('role', 'admin')->get();
    //             Notification::send($admins, new LowStockNotification($product));
    //         }
    //     });
    // }
}
