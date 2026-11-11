<?php

namespace App\Console\Commands;

use App\Mail\PengingatJadwalPustakawan;
use App\Mail\PengingatPengembalian;
use App\Models\JadwalPustakawan;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class KirimPengingatHarian extends Command
{
    protected $signature = 'notifikasi:kirim-harian';
    protected $description = 'Mengirim pengingat jadwal shift dan pengembalian buku';

    public function handle(): int
    {
        $today = Carbon::today();
        $jadwal = JadwalPustakawan::with('pustakawan')->whereDate('tanggal', $today)->get();
        foreach ($jadwal as $item) {
            if ($item->pustakawan?->email) Mail::to($item->pustakawan->email)->send(new PengingatJadwalPustakawan($item));
        }

        $loans = Peminjaman::with(['mahasiswa', 'detailPeminjaman.buku'])
            ->where('status', 'Dipinjam')->whereDate('tgl_tenggat', $today->copy()->addDay())->get();
        foreach ($loans as $loan) {
            if ($loan->mahasiswa?->email) Mail::to($loan->mahasiswa->email)->send(new PengingatPengembalian($loan));
        }

        $this->info("{$jadwal->count()} pengingat shift dan {$loans->count()} pengingat pengembalian dikirim.");
        return self::SUCCESS;
    }
}
