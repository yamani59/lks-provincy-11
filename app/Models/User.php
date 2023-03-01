<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get atribut user data
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Get atribut commands data
     */
    public function commands()
    {
        return $this->hasMany(Command::class);
    }

    /**
     * Get role validasion
     */
    public function hasRole(String $role)
    {
        if (strpos($role, '|') !== false) {
            return in_array($this->role, explode('|', $role));
        } else {
            return $this->role === $role;
        }
    }
}
