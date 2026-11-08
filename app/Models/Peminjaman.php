<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'nim',
        'nip',
        'tgl_pinjam',
        'tgl_tenggat',
        'jumlah_perpanjang',
        'status',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }
}
