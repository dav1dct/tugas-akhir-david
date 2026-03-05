<?php

namespace App\Exports;

use App\Models\KaryawanBaru;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KaryawanBaruExport implements FromCollection, WithHeadings, WithMapping
{
    private $index = 0;

    public function collection()
    {
        return KaryawanBaru::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Lamaran',
            'Nama',
            'Email',
            'No HP',
            'Tanggal Lahir',
            'Pendidikan',
            'Gender',
            'Alamat',
            'Status',
        ];
    }

    public function map($karyawan): array
    {
        $this->index++;

        return [
            $this->index,
            $karyawan->kode_lamaran,
            $karyawan->nama_lengkap,
            $karyawan->email,
            "'" . $karyawan->no_hp,
            $karyawan->tanggal_lahir ? \Carbon\Carbon::parse($karyawan->tanggal_lahir)->format('d-m-Y') : '-',
            $karyawan->pendidikan,
            $karyawan->gender,
            $karyawan->alamat,
            $karyawan->status,
        ];
    }
}
