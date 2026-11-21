<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/** @mixin \Eloquent */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_USER = 'user';

    protected $fillable = ['name', 'email', 'password'];

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
