<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nim', 'nama', 'jurusan', 'angkatan', 'no_hp', 'email', 'status_aktif'];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'nim', 'nim');
    }
}