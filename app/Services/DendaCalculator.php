<?php

namespace App\Services;

use Carbon\Carbon;

class DendaCalculator
{
    /**
     * Tarif denda keterlambatan per hari (Rupiah).
     */
    public function tarifPerHari(): int
    {
        return (int) config('perpustakaan.denda_per_hari', 1000);
    }

    /**
     * Jumlah hari keterlambatan. Mengembalikan 0 jika tidak terlambat.
     */
    public function hitungTerlambatHari(Carbon $tglKembali, Carbon $tglTenggat): int
    {
        $kembali = $tglKembali->copy()->startOfDay();
        $tenggat = $tglTenggat->copy()->startOfDay();

        if ($kembali->lessThanOrEqualTo($tenggat)) {
            return 0;
        }

        return (int) $tenggat->diffInDays($kembali);
    }

    /**
     * Denda keterlambatan berdasarkan jumlah hari.
     */
    public function hitungDendaTerlambat(Carbon $tglKembali, Carbon $tglTenggat): float
    {
        return $this->hitungTerlambatHari($tglKembali, $tglTenggat) * $this->tarifPerHari();
    }

    /**
     * Denda buku hilang: harga buku dikalikan jumlah eksemplar.
     */
    public function hitungDendaHilang(float $harga, int $jumlah = 1): float
    {
        return $harga * max(1, $jumlah);
    }
}
