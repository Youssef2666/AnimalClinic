<?php

namespace App\Models;

use Filament\Panel;
use App\Models\Animal;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;


    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'role'
    ];

    public const ROLES = [
        'user' => 'User',
        'admin' => 'Admin',
        'doctor' => 'Doctor',
        'employee' => 'Employee',
    ];
    
    public const STATUS = [
        'InActive' => 0,
        'Active' => 1,  
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isDoctor()
    {
        return $this->role === 'doctor';
    }
    public function isEmployee()
    {
        return $this->role === 'employee';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function scopeDoctor($query)
    {
        return $query->where('role', 'doctor'); // Adjust as needed
    }

    public function animals(){
        return $this->hasMany(Animal::class);
    }

    public function favouriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favourite_products');
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }


}