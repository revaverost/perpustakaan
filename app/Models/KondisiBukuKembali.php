<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KondisiBukuKembali extends Model
{
    use HasFactory;

    protected $table = 'kondisi_buku_kembali';

    // Izinkan kolom-kolom ini diisi secara mass assignment
    protected $fillable = [
        'id_pengembalian',
        'kode_buku',
        'kondisi',
        'denda_fisik',
        'keterangan',
    ];

    // Hubungan Relasi ke Pengembalian (Opsional)
    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'id_pengembalian', 'id_pengembalian');
    }

    // Hubungan Relasi ke Buku (Opsional)
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'kode_buku', 'kode_buku');
    }
}
