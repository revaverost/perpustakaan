<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('denda', function (Blueprint $table) {
            // 1. Hapus constraint foreign key terlebih dahulu
            $table->dropForeign('denda_nip_foreign');
            
            // 2. Hapus kolom nip
            $table->dropColumn('nip');
        });
    }

    public function down(): void
    {
        Schema::table('denda', function (Blueprint $table) {
            // Kembalikan kolom dan foreign key jika dilakukan rollback
            $table->string('nip', 10)->nullable()->after('id_pengembalian');
            $table->foreign('nip', 'denda_nip_foreign')
                  ->references('nip')
                  ->on('petugas')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }
};