<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatans';

    protected $fillable = [
        'nama',
        'departemen_id',
        'deskripsi',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    // Relasi
    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function karyawans()
    {
        return $this->hasMany(Karyawan::class);
    }
}