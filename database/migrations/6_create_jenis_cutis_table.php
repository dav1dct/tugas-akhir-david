<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_cutis', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique(); // e.g., 'TH', 'SK', 'BS', 'PT', 'LN'
            $table->string('deskripsi');
            $table->integer('durasi_maks')->nullable(); // Durasi maksimal (hari)
            $table->boolean('butuh_persetujuan')->default(true); // Ya/Tidak
            $table->boolean('aktif')->default(true); // Untuk aktif/nonaktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_cutis');
    }
};