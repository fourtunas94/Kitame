<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_verified',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin_pemko';
    }

    public function talent()
    {
        return $this->hasOne(Talent::class);
    }

    public function umkm()
    {
        return $this->hasOne(Umkm::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}