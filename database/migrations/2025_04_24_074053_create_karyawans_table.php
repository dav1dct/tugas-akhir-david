<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('nama_lengkap');
            $table->enum('status_kerja', ['Tetap', 'Tidak Tetap']);
            $table->enum('status_pernikahan', ['Nikah', 'Tidak Nikah']);
            $table->string('alamat');
            $table->string('no_hp');
            $table->string('email')->unique();
            $table->string('posisi');
            $table->string('departemen');
            $table->enum('status', ['Aktif', 'Tidak Aktif', 'Menunggu'])->default('Menunggu');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->date('tanggal_lahir');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
