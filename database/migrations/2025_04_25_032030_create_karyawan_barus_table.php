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
        Schema::create('karyawan_barus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_lamaran');
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('no_hp');
            $table->date('tanggal_lahir');
            $table->string('pendidikan');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->text('alamat');
            $table->enum('status', ['Diterima', 'Ditolak', 'Menunggu'])->default('Menunggu');
            $table->string('surat_lamaran');
            $table->string('foto_identitas');
            $table->string('cv');
            $table->string('ijazah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan_barus');
    }
};
