<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KaryawanExport implements FromCollection, WithHeadings, WithMapping
{
    private $index = 0;

    public function collection()
    {
        return Karyawan::all();
    }

    public function map($karyawan): array
{
    $this->index++;

    return [
        $this->index,
        $karyawan->nik,
        $karyawan->nama_lengkap,
        $karyawan->email,
        "'" . $karyawan->no_hp,
        $karyawan->alamat,
        $this->formatDate($karyawan->tanggal_lahir),
        $karyawan->pendidikan,
        $karyawan->posisi,
        $karyawan->departemen,
        $karyawan->status_kerja,
        $karyawan->status_pernikahan,
        $karyawan->no_rekening,
        $karyawan->status,
        $this->formatDate($karyawan->tanggal_masuk),
        $karyawan->tanggal_keluar ? $this->formatDate($karyawan->tanggal_keluar) : '-',
    ];
}

public function headings(): array
{
    return [
        'No',
        'NIK',
        'Nama',
        'Email',
        'No HP',
        'Alamat',
        'Tanggal Lahir',
        'Pendidikan',
        'Posisi',
        'Departemen',
        'Status Kerja',
        'Status Pernikahan',
        'No Rekening',
        'Status',
        'Tanggal Masuk',
        'Tanggal Keluar',
    ];
}

    private function formatDate($date)
    {
        try {
            return \Carbon\Carbon::parse($date)->format('d-m-Y');
        } catch (\Exception $e) {
            return '-';
        }
    }
}
