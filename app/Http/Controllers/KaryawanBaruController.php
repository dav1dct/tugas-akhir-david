<?php

namespace App\Http\Controllers;

use App\Models\KaryawanBaru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\KaryawanBaruExport;
use Maatwebsite\Excel\Facades\Excel;

class KaryawanBaruController extends Controller
{
    public function index()
    {
        if (!in_array(auth()->user()->role, ['admin', 'hsd'])) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $karyawanbarus = KaryawanBaru::all();
        return view('karyawanbaru.index', compact('karyawanbarus'));
    }

    public function exportExcel()
    {
        if (!in_array(auth()->user()->role, ['admin', 'hsd'])) {
            abort(403, 'Anda tidak memiliki akses.');
        }
        return Excel::download(new KaryawanBaruExport, 'karyawan_baru.xlsx');
    }

    public function create()
    {
        return view('karyawanbaru.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_lamaran' => 'required|string',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:karyawan_barus,email',
            'no_hp' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'pendidikan' => 'required|string',
            'gender' => 'required|string',
            'alamat' => 'required|string',
            'surat_lamaran' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'foto_identitas' => 'required|file|mimes:jpg,jpeg,png|max:10240',
            'cv' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $cvPath = $request->file('cv')->store('uploads/cv', 'public');
        $fotoPath = $request->file('foto_identitas')->store('uploads/foto', 'public');
        $ijazahPath = $request->file('ijazah')->store('uploads/ijazah', 'public');
        $suratPath = $request->file('surat_lamaran')->store('uploads/surat', 'public');

        KaryawanBaru::create([
            'kode_lamaran' => $validated['kode_lamaran'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'pendidikan' => $validated['pendidikan'],
            'gender' => $validated['gender'],
            'alamat' => $validated['alamat'],
            'status' => 'Menunggu',
            'surat_lamaran' => $suratPath,
            'foto_identitas' => $fotoPath,
            'cv' => $cvPath,
            'ijazah' => $ijazahPath,
        ]);

        return redirect()->route('karyawanbaru.success')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function success()
    {
        return view('karyawanbaru.success');
    }

    public function updateStatus(Request $request, $id)
    {
        if (!in_array(auth()->user()->role, ['hsd'])) {
            abort(403, 'Hanya HSD yang dapat mengedit data.');
        }

        $request->validate([
            'status' => 'required|in:Menunggu,Diterima,Ditolak',
        ]);

        $karyawan = KaryawanBaru::findOrFail($id);
        $karyawan->status = $request->status;
        $karyawan->save();

        return redirect()->route('karyawanbaru.index')->with('success', 'Status berhasil diperbarui.');
    }

    public function edit($id)
    {
        if (!in_array(auth()->user()->role, ['hsd'])) {
            abort(403, 'Hanya HSD yang dapat mengedit data.');
        }

        $karyawan = KaryawanBaru::findOrFail($id);
        return view('karyawanbaru.edit', compact('karyawan'));
    }

    public function download($id, $file)
    {
        $allowed = ['cv', 'foto_identitas', 'ijazah', 'surat_lamaran'];
        if (!in_array($file, $allowed)) {
            abort(403, 'Akses file tidak valid.');
        }

        $karyawan = KaryawanBaru::findOrFail($id);
        $path = $karyawan->{$file};

        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($path, basename($path));
    }

    public function showImage($id, $file)
    {
        $allowed = ['foto_identitas'];
        if (!in_array($file, $allowed)) {
            abort(403, 'Akses file tidak valid.');
        }

        $karyawan = KaryawanBaru::findOrFail($id);
        $path = $karyawan->{$file};

        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->file(Storage::disk('public')->path($path));
    }
}
