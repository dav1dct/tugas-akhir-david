<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',  // Tambahan: agar role bisa diisi via create/fill
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke table karyawans (asumsi model Karyawan sudah ada)
    public function karyawan()
    {
        return $this->hasOne(Karyawan::class);
    }

    // Helper untuk cek role (mudah dipakai di blade, controller, middleware)
    public function isPimpinan(): bool
    {
        return $this->role === 'pimpinan';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isHsd(): bool
    {
        return $this->role === 'hsd';
    }

    public function isKaryawan(): bool
    {
        return $this->role === 'karyawan';
    }

    // Opsional: cek multiple role sekaligus
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }
}