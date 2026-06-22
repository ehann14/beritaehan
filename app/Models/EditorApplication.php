<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'address',
        'reason',
        'status',
        'rejection_reason',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    // Relasi ke user yang mendaftar
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke admin yang review
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Scope: pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope: approved
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope: rejected
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}