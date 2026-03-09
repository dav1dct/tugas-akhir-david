<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jabatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('departemen_id')
                  ->constrained('departemens')
                  ->onDelete('restrict');
            $table->text('deskripsi')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            // Satu departemen tidak boleh punya jabatan nama yang sama
            $table->unique(['nama', 'departemen_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jabatans');
    }
};