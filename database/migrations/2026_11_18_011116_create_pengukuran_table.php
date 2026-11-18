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
        Schema::create('pengukuran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('waktu_ukur')->comment('Tanggal & jam pengukuran');
            $table->unsignedSmallInteger('sistolik')->comment('mmHg, 70-250');
            $table->unsignedSmallInteger('diastolik')->comment('mmHg, 40-150');
            $table->unsignedSmallInteger('nadi')->nullable()->comment('bpm, opsional');
            $table->enum('status', ['normal', 'meningkat', 'hipertensi_1', 'hipertensi_2'])->comment('Dihitung otomatis saat simpan');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['pengguna_id', 'waktu_ukur']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengukuran');
    }
};
