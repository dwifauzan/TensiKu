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
        Schema::create('tips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dibuat_oleh')->comment('Admin pembuat tips')->constrained('users');
            $table->string('judul');
            $table->text('isi');
            $table->enum('kategori', ['normal', 'meningkat', 'hipertensi_1', 'hipertensi_2'])->nullable()->comment('Null = tips umum');
            $table->string('gambar')->nullable()->comment('Path gambar, opsional');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tips');
    }
};
