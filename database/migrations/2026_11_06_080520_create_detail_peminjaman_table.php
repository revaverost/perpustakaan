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
        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_peminjaman');

            // Wajib berukuran 6 karakter agar cocok dengan tabel buku!
            $table->string('kode_buku', 6);
            $table->integer('jumlah')->default(1);
            $table->timestamps();

            // Foreign Keys
            $table->foreign('id_peminjaman')
                ->references('id_peminjaman')
                ->on('peminjaman')
                ->onDelete('cascade');

            $table->foreign('kode_buku')
                ->references('kode_buku')
                ->on('buku')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman');
    }
};
