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
        Schema::create('buku', function (Blueprint $table) {
            $table->string('kode_buku', 6)->primary();
            $table->string('judul', 200);
            $table->string('pengarang', 100);
            $table->string('penerbit', 100);
            $table->string('tahun_terbit', 4);
            $table->string('kategori', 50);
            $table->integer('stok')->default(0);
            $table->decimal('harga', 10, 2)->default(0); 
            $table->string('lokasi_rak', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};