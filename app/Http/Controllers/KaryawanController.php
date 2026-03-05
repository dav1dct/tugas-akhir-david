<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Exports\KaryawanExport;
use Maatwebsite\Excel\Facades\Excel;

class KaryawanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        if ($user->isKaryawan()) {
            // Karyawan biasa hanya melihat data dirinya sendiri
            $karyawan = Karyawan::where('email', $user->email)->first();
    
            if (!$karyawan) {
                return view('karyawan.index', ['karyawans' => collect([])])
                    ->with('error', 'Data karyawan Anda tidak ditemukan. Hubungi HSD.');
            }
    
            $karyawans = collect([$karyawan]);   // hanya 1 data
        } 
        else {
            // Admin, HSD, dan Pimpinan bisa melihat semua data
            $karyawans = Karyawan::latest()->get();
        }
    
        return view('karyawan.index', compact('karyawans'));
    }
    public function exportExcel()
    {
        if (!in_array(auth()->user()->role, ['admin', 'hsd'])) {
            abort(403, 'Anda tidak memiliki akses.');
        }
    
        return Excel::download(new KaryawanExport, 'karyawan.xlsx');
    }
    public function create()
    {
        if (auth()->user()->role !== 'hsd') {
            abort(403, 'Anda tidak memiliki akses.');
        }
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'hsd') {
            abort(403, 'Anda tidak memiliki akses.');
        }
    
        $validated = $request->validate([
            'nik' => 'required|numeric|unique:karyawans',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:karyawans',
            'no_hp' => 'required|numeric',
            'alamat' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'departemen' => 'required|string|max:255',
            'status_kerja' => 'required|in:Tetap,Tidak Tetap',
            'status_pernikahan' => 'required|in:Nikah,Tidak Nikah',
            'pendidikan' => 'required|string|max:100',
            'no_rekening' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'status' => 'required|in:Aktif,Tidak Aktif,Menunggu',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date',
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
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        if (auth()->user()->role !== 'hsd') {
            abort(403, 'Hanya HSD yang dapat mengedit data.');
        }
    
        $validated = $request->validate([
            'nik' => 'required|numeric|unique:karyawans,nik,' . $karyawan->id,
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:karyawans,email,' . $karyawan->id,
            'no_hp' => 'required|numeric',
            'alamat' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'departemen' => 'required|string|max:255',
            'status_kerja' => 'required|in:Tetap,Tidak Tetap',
            'status_pernikahan' => 'required|in:Nikah,Tidak Nikah',
            'status' => 'required|in:Aktif,Tidak Aktif,Menunggu',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date',
            'pendidikan' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'no_rekening' => 'required|string|max:100',
        ]);
    
        if ($request->status == 'Tidak Aktif' && !$karyawan->tanggal_keluar) {
            $validated['tanggal_keluar'] = now();
        }
    
        $karyawan->update($validated);
    
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui!');
    }
    
}
