<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'detail_peminjaman';

    protected $fillable = [
        'id_peminjaman',
        'kode_buku',
        'jumlah',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'kode_buku', 'kode_buku');
    }
}
