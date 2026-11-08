<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Primary key kustom menggunakan NIP (10 karakter CHAR)
     */
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Field yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nip',
        'nama',
        'email',
        'password',
        'role',
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

    // ==========================================
    // RELASI ELOQUENT
    // ==========================================

    /**
     * Transaksi peminjaman yang dilayani oleh user ini.
     */
    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'nip', 'nip');
    }

    /**
     * Transaksi pengembalian yang diterima oleh user ini.
     */
    public function pengembalian(): HasMany
    {
        return $this->hasMany(Pengembalian::class, 'nip', 'nip');
    }

    /**
     * Pembayaran denda yang diproses oleh user ini.
     */
    public function denda(): HasMany
    {
        return $this->hasMany(Denda::class, 'nip', 'nip');
    }
}