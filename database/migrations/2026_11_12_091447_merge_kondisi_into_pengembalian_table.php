<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Pastikan tabel kondisi_buku_kembali dihapus jika masih ada
        Schema::dropIfExists('kondisi_buku_kembali');

        // 2. Lepas unique key pada id_peminjaman jika masih ada
        Schema::table('pengembalian', function (Blueprint $table) {
            // Cek apakah index unique masih ada sebelum dihapus
            $indexes = collect(DB::select("SHOW INDEX FROM pengembalian"))->pluck('Key_name');
            if ($indexes->contains('pengembalian_id_peminjaman_unique')) {
                $table->dropForeign(['id_peminjaman']);
                $table->dropUnique('pengembalian_id_peminjaman_unique');
                $table->foreign('id_peminjaman')->references('id_peminjaman')->on('peminjaman')->onDelete('cascade');
            }

            // Tambahkan kolom jika belum sempat terbuat pada percobaan sebelumnya
            if (!Schema::hasColumn('pengembalian', 'kode_buku')) {
                $table->string('kode_buku', 6)->nullable()->after('id_peminjaman');
            }
            if (!Schema::hasColumn('pengembalian', 'kondisi')) {
                $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Hilang'])->default('Baik')->after('terlambat_hari');
            }
            if (!Schema::hasColumn('pengembalian', 'denda_fisik')) {
                $table->decimal('denda_fisik', 10, 2)->default(0)->after('kondisi');
            }
            if (!Schema::hasColumn('pengembalian', 'keterangan_kondisi')) {
                $table->string('keterangan_kondisi', 255)->nullable()->after('denda_fisik');
            }
        });

        // 3. Isi kolom kode_buku pada data lama dari tabel detail_peminjaman agar valid untuk Foreign Key
        DB::statement("
            UPDATE pengembalian p
            JOIN detail_peminjaman dp ON p.id_peminjaman = dp.id_peminjaman
            SET p.kode_buku = dp.kode_buku
            WHERE p.kode_buku IS NULL OR p.kode_buku = ''
        ");

        // 4. Ubah kode_buku menjadi NOT NULL dan pasang Foreign Key ke tabel buku
        Schema::table('pengembalian', function (Blueprint $table) {
            $table->string('kode_buku', 6)->nullable(false)->change();
            $table->foreign('kode_buku')
                  ->references('kode_buku')
                  ->on('buku')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            $table->dropForeign(['kode_buku']);
            $table->dropColumn(['kode_buku', 'kondisi', 'denda_fisik', 'keterangan_kondisi']);
        });
    }
};