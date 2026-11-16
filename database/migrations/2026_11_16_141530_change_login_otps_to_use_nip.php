<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('login_otps')->truncate();

        Schema::table('login_otps', function (Blueprint $table) {
            // Hapus index lama jika masih ada
            if (Schema::hasIndex('login_otps', 'login_otps_user_type_email_index')) {
                $table->dropIndex('login_otps_user_type_email_index');
            }

            // Hapus kolom user_type & user_id jika belum terhapus saat percobaan pertama
            if (Schema::hasColumn('login_otps', 'user_type')) {
                $table->dropColumn('user_type');
            }
            if (Schema::hasColumn('login_otps', 'user_id')) {
                $table->dropColumn('user_id');
            }

            // Tambahkan kolom nip jika belum terbentuk saat percobaan pertama
            if (!Schema::hasColumn('login_otps', 'nip')) {
                $table->string('nip', 10)->after('id');
            }

            // Arahkan Foreign Key ke tabel 'petugas'
            $table->foreign('nip')
                  ->references('nip')
                  ->on('petugas')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->index(['nip', 'email']);
        });
    }

    public function down(): void
    {
        Schema::table('login_otps', function (Blueprint $table) {
            $table->dropForeign(['nip']);
            $table->dropIndex(['nip', 'email']);
            $table->dropColumn('nip');

            $table->string('user_type', 20)->after('id');
            $table->string('user_id', 20)->after('user_type');
            $table->index(['user_type', 'email'], 'login_otps_user_type_email_index');
        });
    }
};