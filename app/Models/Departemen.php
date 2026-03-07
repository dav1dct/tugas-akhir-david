<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    protected $table = 'departemens';

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    // Relasi
    public function jabatans()
    {
        return $this->hasMany(Jabatan::class);
    }

    public function karyawans()
    {
        return $this->hasMany(Karyawan::class);
    }
}