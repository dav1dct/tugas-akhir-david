<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',             
        'nama_lengkap',   
        'email',             
        'telepon',           
        'jenis_kelamin',    
        'tanggal_lahir',     
        'alamat',         
        'posisi',          
        'departemen',    
        'status',            
        'tanggal_masuk',     
        'tanggal_keluar',    
        'status_kerja',       
        'status_pernikahan', 
        'no_hp',  
        'pendidikan',
        'no_rekening',      
        'departemen_id',
        'jabatan_id',      
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}