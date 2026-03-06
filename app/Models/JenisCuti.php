<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisCuti extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'deskripsi',
        'durasi_maks',
        'butuh_persetujuan',
        'aktif',
    ];
}