<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambahkan kolom denda_terlambat & denda_fisik ke tabel denda
        Schema::table('denda', function (Blueprint $table) {
            if (!Schema::hasColumn('denda', 'denda_terlambat')) {
                $table->decimal('denda_terlambat', 10, 2)->default(0)->after('nip');
            }
            if (!Schema::hasColumn('denda', 'denda_fisik')) {
                $table->decimal('denda_fisik', 10, 2)->default(0)->after('denda_terlambat');
            }
        });

        // 2. Pindahkan data denda_fisik lama dari pengembalian ke denda (jika ada)
        if (Schema::hasColumn('pengembalian', 'denda_fisik')) {
            DB::statement("
                UPDATE denda d
                JOIN pengembalian p ON d.id_pengembalian = p.id_pengembalian
                SET d.denda_fisik = p.denda_fisik,
                    d.denda_terlambat = GREATEST(d.jumlah_denda - p.denda_fisik, 0)
            ");

            // 3. Hapus kolom denda_fisik dari tabel pengembalian
            Schema::table('pengembalian', function (Blueprint $table) {
                $table->dropColumn('denda_fisik');
            });
        }
    }

    public function down(): void
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            if (!Schema::hasColumn('pengembalian', 'denda_fisik')) {
                $table->decimal('denda_fisik', 10, 2)->default(0)->after('kondisi');
            }
        });

        Schema::table('denda', function (Blueprint $table) {
            $table->dropColumn(['denda_terlambat', 'denda_fisik']);
        });
    }
};
