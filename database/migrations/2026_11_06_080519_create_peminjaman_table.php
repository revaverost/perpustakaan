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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->string('nim', 9);
            $table->string('nip', 10);
            $table->date('tgl_pinjam');
            $table->date('tgl_tenggat');
            $table->integer('jumlah_perpanjang')->default(0);
            $table->enum('status', ['Dipinjam', 'Selesai'])->default('Dipinjam');
            $table->timestamps();

            // Foreign Keys
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('nip')->references('nip')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
