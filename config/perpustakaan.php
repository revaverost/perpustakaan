<?php

return [
    // Lama masa pinjam default (hari)
    'durasi_pinjam_hari' => (int) env('DURASI_PINJAM_HARI', 14),

    // Lama perpanjangan sekali ajukan (hari)
    'perpanjangan_hari' => (int) env('PERPANJANGAN_HARI', 7),

    // Batas maksimal jumlah perpanjangan per transaksi
    'maks_perpanjangan' => (int) env('MAKS_PERPANJANGAN', 2),

    // Tarif denda keterlambatan per hari (Rupiah)
    'denda_per_hari' => (int) env('DENDA_PER_HARI', 1000),
];
