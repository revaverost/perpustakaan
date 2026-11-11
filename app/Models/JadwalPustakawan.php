<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPustakawan extends Model
{
    protected $table = 'jadwal_pustakawan';

    protected $fillable = ['user_id', 'tanggal', 'shift_mulai', 'shift_selesai'];

    protected $casts = ['tanggal' => 'date'];

    public function pustakawan()
    {
        return $this->belongsTo(User::class, 'user_id', 'nip');
    }
}
