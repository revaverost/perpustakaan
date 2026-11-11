<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_pustakawan', function (Blueprint $table) {
            $table->id();
            // User memakai NIP sebagai primary key, sehingga user_id menyimpan NIP.
            $table->string('user_id', 10);
            $table->date('tanggal');
            $table->time('shift_mulai');
            $table->time('shift_selesai');
            $table->timestamps();

            $table->foreign('user_id')->references('nip')->on('users')->cascadeOnDelete();
            $table->index(['tanggal', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_pustakawan');
    }
};
