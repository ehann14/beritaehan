<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo',
        'gender',
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

    // Relasi: user bisa membuat banyak post
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Relasi: user bisa membuat banyak komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Helper: cek apakah user adalah admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Helper: cek apakah user adalah editor
    public function isEditor()
    {
        return $this->role === 'editor';
    }

    // Helper: cek apakah user bisa manage posts
    public function canManagePosts()
    {
        return in_array($this->role, ['admin', 'editor']);
    }
}