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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('nim', 9)->primary(); // Primary key NIM
            $table->string('nama', 100);
            $table->string('jurusan', 50);
            $table->string('angkatan', 4);
            $table->string('no_hp', 15)->nullable();
            $table->string('email', 100)->unique();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
