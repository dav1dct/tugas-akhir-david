<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->foreignId('jenis_cuti_id')->nullable()->constrained('jenis_cutis')->onDelete('set null');
            $table->index('jenis_cuti_id');
        });
    }

    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropForeign(['jenis_cuti_id']);
            $table->dropColumn('jenis_cuti_id');
        });
    }
};