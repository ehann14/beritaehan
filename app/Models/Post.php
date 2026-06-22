<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'author',
        'thumbnail',
        'status',
        'published_at',
        'review_status',
        'rejection_reason',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    // Auto-generate slug saat creating
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            // Default review_status untuk editor = pending
            if (empty($post->review_status)) {
                if (auth()->check() && auth()->user()->role === 'editor') {
                    $post->review_status = 'pending';
                    $post->status = 'draft';
                }
            }
        });
    }

    // Relasi: setiap post dibuat oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

    // Relasi: setiap post bisa punya banyak komentar
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    // Relasi: admin yang me-review berita ini
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Scope untuk published posts (harus approved juga)
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where('review_status', 'approved')
                     ->whereNotNull('published_at');
    }

    // Scope untuk draft posts
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // Scope: menunggu review
    public function scopePending($query)
    {
        return $query->where('review_status', 'pending');
    }

    // Scope: sudah disetujui
    public function scopeApproved($query)
    {
        return $query->where('review_status', 'approved');
    }

    // Scope: ditolak
    public function scopeRejected($query)
    {
        return $query->where('review_status', 'rejected');
    }
}