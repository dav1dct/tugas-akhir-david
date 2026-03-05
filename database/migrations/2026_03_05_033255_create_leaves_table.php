<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade'); // relasi ke karyawan
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('jenis_cuti', ['tahunan', 'sakit', 'bersalin', 'penting', 'lainnya'])->default('tahunan');
            $table->text('alasan')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null'); // siapa yang approve (admin/hsd/pimpinan)
            $table->timestamp('approved_at')->nullable();
            $table->text('catatan_penolakan')->nullable(); // kalau rejected
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};