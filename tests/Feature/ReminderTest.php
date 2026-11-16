<?php

namespace Tests\Feature;

use App\Mail\PengingatTenggatMail;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\Support\CreatesLibraryData;
use Tests\TestCase;

class ReminderTest extends TestCase
{
    use CreatesLibraryData, RefreshDatabase;

    public function test_reminder_is_queued_to_mahasiswa_email_before_due_date(): void
    {
        Mail::fake();

        $pustakawan = $this->makeUser('Pustakawan');
        $mahasiswa = $this->makeMahasiswa();
        $buku = $this->makeBuku();

        $peminjaman = Peminjaman::create([
            'nim' => $mahasiswa->nim,
            'nip' => $pustakawan->nip,
            'tgl_pinjam' => now()->subDays(6),
            'tgl_tenggat' => now()->addDay(),
            'status' => 'Dipinjam',
        ]);

        DetailPeminjaman::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'kode_buku' => $buku->kode_buku,
            'jumlah' => 1,
        ]);

        $this->artisan('siperpus:pengingat-tenggat')->assertExitCode(0);

        Mail::assertSent(PengingatTenggatMail::class, function ($mail) use ($mahasiswa) {
            return $mail->hasTo($mahasiswa->email);
        });

        $this->assertNotNull($peminjaman->fresh()->terakhir_pengingat);
    }

    public function test_reminder_is_not_sent_twice_on_the_same_day(): void
    {
        Mail::fake();

        $pustakawan = $this->makeUser('Pustakawan');
        $mahasiswa = $this->makeMahasiswa();
        $buku = $this->makeBuku();

        $peminjaman = Peminjaman::create([
            'nim' => $mahasiswa->nim,
            'nip' => $pustakawan->nip,
            'tgl_pinjam' => now()->subDays(6),
            'tgl_tenggat' => now()->addDay(),
            'status' => 'Dipinjam',
            'terakhir_pengingat' => now(),
        ]);

        DetailPeminjaman::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'kode_buku' => $buku->kode_buku,
            'jumlah' => 1,
        ]);

        $this->artisan('siperpus:pengingat-tenggat')->assertExitCode(0);

        Mail::assertNotSent(PengingatTenggatMail::class);
    }
}
