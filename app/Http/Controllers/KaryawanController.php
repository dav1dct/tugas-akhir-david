<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Departemen;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;

class KaryawanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isKaryawan()) {
            $karyawan = Karyawan::with(['departemen', 'jabatan'])
                ->where('email', $user->email)->first();

            if (!$karyawan) {
                return view('karyawan.index', ['karyawans' => collect([])])
                    ->with('error', 'Data karyawan Anda tidak ditemukan. Hubungi HSD.');
            }

            $karyawans = collect([$karyawan]);
        } else {
            $karyawans = Karyawan::with(['departemen', 'jabatan'])->latest()->get();
        }

        return view('karyawan.index', compact('karyawans'));
    }

    public function export()
    {
        $karyawans = Karyawan::with(['departemen', 'jabatan'])->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'No', 'NIK', 'Nama', 'Email', 'No HP', 'Alamat',
            'Tanggal Lahir', 'Pendidikan', 'Jabatan', 'Departemen',
            'Status Kerja', 'Status Pernikahan', 'No Rekening',
            'Status', 'Tanggal Masuk', 'Tanggal Keluar'
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $col++;
        }

        $row = 2;
        $no = 1;

        foreach ($karyawans as $k) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $k->nik);
            $sheet->setCellValue('C' . $row, $k->nama_lengkap);
            $sheet->setCellValue('D' . $row, $k->email);
            $sheet->setCellValue('E' . $row, $k->no_hp);
            $sheet->setCellValue('F' . $row, $k->alamat);
            $sheet->setCellValue('G' . $row, Carbon::parse($k->tanggal_lahir)->format('d-m-Y'));
            $sheet->setCellValue('H' . $row, $k->pendidikan);
            $sheet->setCellValue('I' . $row, $k->jabatan?->nama ?? $k->posisi);
            $sheet->setCellValue('J' . $row, $k->departemen?->nama ?? $k->departemen);
            $sheet->setCellValue('K' . $row, $k->status_kerja);
            $sheet->setCellValue('L' . $row, $k->status_pernikahan);
            $sheet->setCellValue('M' . $row, $k->no_rekening);
            $sheet->setCellValue('N' . $row, $k->status);
            $sheet->setCellValue('O' . $row, Carbon::parse($k->tanggal_masuk)->format('d-m-Y'));
            $sheet->setCellValue('P' . $row, $k->tanggal_keluar ? Carbon::parse($k->tanggal_keluar)->format('d-m-Y') : '-');
            $row++;
        }

        foreach (range('A', 'P') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'data_karyawan.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function create()
    {
        if (auth()->user()->role !== 'hsd') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $departemens = Departemen::orderBy('aktif', 'desc')->orderBy('nama')->get();
        $jabatans = Jabatan::with('departemen')->orderBy('aktif', 'desc')->orderBy('nama')->get();

        return view('karyawan.create', compact('departemens', 'jabatans'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'hsd') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $validated = $request->validate([
            'nik'               => 'required|numeric|unique:karyawans',
            'nama_lengkap'      => 'required|string|max:255',
            'email'             => 'required|email|unique:karyawans',
            'no_hp'             => 'required|numeric',
            'alamat'            => 'required|string|max:255',
            'departemen_id'     => 'required|exists:departemens,id',
            'jabatan_id'        => 'required|exists:jabatans,id',
            'status_kerja'      => 'required|in:Tetap,Tidak Tetap',
            'status_pernikahan' => 'required|in:Nikah,Tidak Nikah',
            'pendidikan'        => 'required|string|max:100',
            'no_rekening'       => 'required|string|max:100',
            'tanggal_lahir'     => 'required|date',
            'status'            => 'required|in:Aktif,Tidak Aktif,Menunggu',
            'tanggal_masuk'     => 'required|date',
            'tanggal_keluar'    => 'nullable|date',
        ]);

        if ($request->status == 'Tidak Aktif' && !$request->tanggal_keluar) {
            $validated['tanggal_keluar'] = now();
        }

        Karyawan::create($validated);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    public function edit(Karyawan $karyawan)
    {
        if (auth()->user()->role !== 'hsd') {
            abort(403, 'Hanya HSD yang dapat mengedit data.');
        }

        $departemens = Departemen::orderBy('aktif', 'desc')->orderBy('nama')->get();
        $jabatans = Jabatan::with('departemen')->orderBy('aktif', 'desc')->orderBy('nama')->get();

        return view('karyawan.edit', compact('karyawan', 'departemens', 'jabatans'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        if (auth()->user()->role !== 'hsd') {
            abort(403, 'Hanya HSD yang dapat mengedit data.');
        }

        $validated = $request->validate([
            'nik'               => 'required|numeric|unique:karyawans,nik,' . $karyawan->id,
            'nama_lengkap'      => 'required|string|max:255',
            'email'             => 'required|email|unique:karyawans,email,' . $karyawan->id,
            'no_hp'             => 'required|numeric',
            'alamat'            => 'required|string|max:255',
            'departemen_id'     => 'required|exists:departemens,id',
            'jabatan_id'        => 'required|exists:jabatans,id',
            'status_kerja'      => 'required|in:Tetap,Tidak Tetap',
            'status_pernikahan' => 'required|in:Nikah,Tidak Nikah',
            'status'            => 'required|in:Aktif,Tidak Aktif,Menunggu',
            'tanggal_masuk'     => 'required|date',
            'tanggal_keluar'    => 'nullable|date',
            'pendidikan'        => 'required|string|max:100',
            'tanggal_lahir'     => 'required|date',
            'no_rekening'       => 'required|string|max:100',
        ]);

        if ($request->status == 'Tidak Aktif' && !$karyawan->tanggal_keluar) {
            $validated['tanggal_keluar'] = now();
        }

        $karyawan->update($validated);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui!');
    }
}