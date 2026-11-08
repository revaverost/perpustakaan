<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id('id_pengembalian');
            $table->unsignedBigInteger('id_peminjaman')->unique();
            $table->string('nip', 10);
            $table->date('tgl_kembali');
            $table->integer('terlambat_hari')->default(0);
            $table->timestamps();

            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('peminjaman')->onDelete('cascade');
            $table->foreign('nip')->references('nip')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
