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
            $table->string('email')->unique();
            $table->string('no_hp');
            $table->string('alamat');
            $table->date('tanggal_lahir');
            $table->string('pendidikan');
            $table->foreignId('departemen_id')->nullable()->constrained('departemens')->nullOnDelete();
            $table->foreignId('jabatan_id')->nullable()->constrained('jabatans')->nullOnDelete();
            $table->enum('status_kerja', ['Tetap', 'Tidak Tetap']);
            $table->enum('status_pernikahan', ['Nikah', 'Tidak Nikah']);
            $table->string('no_rekening');
            $table->enum('status', ['Aktif', 'Tidak Aktif', 'Menunggu'])->default('Menunggu');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
