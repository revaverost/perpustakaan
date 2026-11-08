<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    use HasFactory;

    protected $table = 'denda';
    protected $primaryKey = 'id_denda';

    protected $fillable = [
        'id_pengembalian',
        'jumlah_denda',
        'status_bayar',
        'keterangan',
        'tgl_bayar',
        'metode_bayar',
        'nip',
    ];

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'id_pengembalian', 'id_pengembalian');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
