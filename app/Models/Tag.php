<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post; // <-- tambahkan ini

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug', // opsional, tapi disarankan
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}