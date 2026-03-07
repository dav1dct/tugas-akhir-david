<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->foreignId('departemen_id')->nullable()
                  ->constrained('departemens')
                  ->onDelete('set null');

            $table->foreignId('jabatan_id')->nullable()
                  ->constrained('jabatans')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->dropForeign(['departemen_id']);
            $table->dropForeign(['jabatan_id']);
            $table->dropColumn(['departemen_id', 'jabatan_id']);
        });
    }
};