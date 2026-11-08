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
        Schema::create('denda', function (Blueprint $table) {
            $table->id('id_denda');
            $table->unsignedBigInteger('id_pengembalian')->unique();
            $table->string('nip', 10)->nullable();
            $table->decimal('jumlah_denda', 10, 2)->default(0);
            $table->enum('status_bayar', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->string('keterangan', 50)->nullable();
            $table->timestamp('tgl_bayar')->nullable();
            $table->enum('metode_bayar', ['Tunai', 'QRIS', 'Transfer'])->nullable();
            $table->timestamps();

            $table->foreign('id_pengembalian')->references('id_pengembalian')->on('pengembalian')->onDelete('cascade');
            $table->foreign('nip')->references('nip')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denda');
    }
};
