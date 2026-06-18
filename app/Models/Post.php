<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment; // <-- tambahkan relasi komentar

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'author',
        'thumbnail',
        'category_id',
    ];

    // Relasi: setiap post punya satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: setiap post bisa punya banyak tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // 🔹 Relasi BARU: setiap post bisa punya banyak komentar
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}