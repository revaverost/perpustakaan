<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';
    protected $primaryKey = 'id_pengembalian';

    protected $fillable = [
        'id_peminjaman',
        'kode_buku',
        'nip',
        'tgl_kembali',
        'terlambat_hari',
        'kondisi',
        'keterangan_kondisi',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'kode_buku', 'kode_buku');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    public function denda()
    {
        return $this->hasOne(Denda::class, 'id_pengembalian', 'id_pengembalian');
    }
}