<?php

namespace App\Console\Commands;

use App\Mail\PengingatTenggatMail;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KirimPengingatTenggat extends Command
{
    /**
     * Nama signature command untuk dijalankan via Artisan / Scheduler.
     */
    protected $signature = 'siperpus:pengingat-tenggat';

    /**
     * Deskripsi command.
     */
    protected $description = 'Mengirim email pengingat H-1 sebelum tanggal tenggat pengembalian buku';

    public function handle()
    {
        $besok = Carbon::tomorrow()->toDateString();

        // Cari semua peminjaman berstatus Dipinjam yang tenggatnya tepat besok
        $daftarPeminjaman = Peminjaman::with(['mahasiswa', 'detailPeminjaman.buku', 'pengembalian'])
            ->where('status', 'Dipinjam')
            ->whereDate('tgl_tenggat', $besok)
            ->get();

        if ($daftarPeminjaman->isEmpty()) {
            $this->info("Tidak ada peminjaman yang jatuh tempo pada tanggal {$besok}.");
            return Command::SUCCESS;
        }

        $terkirim = 0;

        foreach ($daftarPeminjaman as $peminjaman) {
            if (empty($peminjaman->mahasiswa->email)) {
                continue;
            }

            // Filter sisa buku yang belum dikembalikan (mendukung pengembalian parsial)
            $kodeSudahKembali = $peminjaman->pengembalian->pluck('kode_buku')->toArray();
            $sisaBuku = $peminjaman->detailPeminjaman->reject(function ($detail) use ($kodeSudahKembali) {
                return in_array($detail->kode_buku, $kodeSudahKembali);
            });

            if ($sisaBuku->isEmpty()) {
                continue;
            }

            try {
                Mail::to($peminjaman->mahasiswa->email)
                    ->send(new PengingatTenggatMail($peminjaman, $sisaBuku));

                $terkirim++;
                $this->info("Pengingat terkirim ke {$peminjaman->mahasiswa->email} (ID Pinjam #{$peminjaman->id_peminjaman})");
            } catch (\Exception $e) {
                Log::error("Gagal mengirim email pengingat tenggat #{$peminjaman->id_peminjaman}: " . $e->getMessage());
                $this->error("Gagal mengirim ke {$peminjaman->mahasiswa->email}: " . $e->getMessage());
            }
        }

        $this->info("Selesai. Total email pengingat terkirim: {$terkirim}.");
        return Command::SUCCESS;
    }
}