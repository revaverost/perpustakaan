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
        Schema::create('kondisi_buku_kembali', function (Blueprint $table) {
            $table->id('id_kondisi');
            $table->unsignedBigInteger('id_pengembalian');
            $table->string('kode_buku', 6);
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Hilang'])->default('Baik');
            $table->decimal('denda_fisik', 10, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_pengembalian')->references('id_pengembalian')->on('pengembalian')->onDelete('cascade');
            $table->foreign('kode_buku')->references('kode_buku')->on('buku')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kondisi_buku_kembali');
    }
};
