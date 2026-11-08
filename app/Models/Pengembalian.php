<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian';
    protected $primaryKey = 'id_pengembalian';

    protected $fillable = [
        'id_peminjaman',
        'tgl_kembali',
        'terlambat_hari',
        'nip',
    ];

    /**
     * Relasi ke Kondisi Buku Kembali (1 Pengembalian punya banyak catatan kondisi)
     */
    public function kondisiBukuKembali()
    {
        return $this->hasMany(KondisiBukuKembali::class, 'id_pengembalian', 'id_pengembalian');
    }

    /**
     * Relasi ke Peminjaman
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    /**
     * Relasi ke User / Petugas (Penerima)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    /**
     * Relasi ke Denda (1 Pengembalian punya 1 Denda jika ada)
     */
    public function denda()
    {
        return $this->hasOne(Denda::class, 'id_pengembalian', 'id_pengembalian');
    }
}
