<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginOtp extends Model
{
    protected $fillable = [
        'nip',
        'email',
        'code_hash',
        'attempts',
        'expires_at',
        'consumed_at',
        'ip_address',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'consumed_at' => 'datetime',
    ];

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}