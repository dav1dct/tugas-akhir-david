<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Karyawan;
use App\Models\KaryawanBaru;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahKaryawan = null;
        $jumlahKaryawanBaru = null;
    
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'hsd') {
            $jumlahKaryawan = Karyawan::count();
            $jumlahKaryawanBaru = KaryawanBaru::count();
        }
    
        return view('dashboard', compact('jumlahKaryawan', 'jumlahKaryawanBaru'));
    }
    

    public function uploadPDF(Request $request)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'hsd') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $request->validate([
            'file' => 'required|mimes:pdf|max:20480',
        ]);

        // Hapus file lama jika ada
        if (Storage::disk('public')->exists('pengumuman.pdf')) {
            Storage::disk('public')->delete('pengumuman.pdf');
        }

        // Simpan file baru sebagai "pengumuman.pdf"
        $request->file('file')->storeAs('public', 'pengumuman.pdf');

        return redirect()->back()->with('success', 'Pengumuman berhasil diunggah.');
    }
}

