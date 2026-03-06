<?php

namespace App\Http\Controllers;

use App\Models\JenisCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisCutiController extends Controller
{
    /**
     * Semua role boleh lihat daftar jenis cuti
     */
    public function index()
    {
        $jenisCutis = JenisCuti::latest()->get();
        return view('jenis-cuti.index', compact('jenisCutis'));
    }

    /**
     * Hanya HSD yang boleh buka form tambah
     */
    public function create()
    {
        if (!Auth::user()->isHsd()) {
            abort(403, 'Hanya HSD yang boleh menambah jenis cuti.');
        }
        return view('jenis-cuti.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isHsd()) {
            abort(403);
        }

        $request->validate([
            'kode' => 'required|string|max:10|unique:jenis_cutis,kode',
            'deskripsi' => 'required|string|max:255',
            'durasi_maks' => 'nullable|integer|min:1',
            'butuh_persetujuan' => 'boolean',
            'aktif' => 'boolean',
        ]);

        JenisCuti::create($request->all());

        return redirect()->route('jenis-cuti.index')
                         ->with('success', 'Jenis cuti berhasil ditambahkan.');
    }

    /**
     * Semua role boleh lihat detail (opsional, kalau kamu punya halaman show)
     */
    public function show(JenisCuti $jenisCuti)
    {
        return view('jenis-cuti.show', compact('jenisCuti'));
    }

    /**
     * Hanya HSD yang boleh buka form edit (termasuk toggle aktif)
     */
    public function edit(JenisCuti $jenisCuti)
    {
        if (!Auth::user()->isHsd()) {
            abort(403, 'Hanya HSD yang boleh mengedit jenis cuti.');
        }
        return view('jenis-cuti.edit', compact('jenisCuti'));
    }

    public function update(Request $request, JenisCuti $jenisCuti)
    {
        if (!Auth::user()->isHsd()) {
            abort(403);
        }
    
        $request->validate([
            'kode' => 'required|string|max:10|unique:jenis_cutis,kode,' . $jenisCuti->id,
            'deskripsi' => 'required|string|max:255',
            'durasi_maks' => 'nullable|integer|min:1',
            // 'butuh_persetujuan' dan 'aktif' tidak perlu validasi 'boolean' lagi
        ]);
    
        // Ambil semua data dari request
        $data = $request->all();
    
        // Fix checkbox: kalau field tidak terkirim (tidak dicentang) → false
        $data['butuh_persetujuan'] = $request->filled('butuh_persetujuan') ? true : false;
        $data['aktif'] = $request->filled('aktif') ? true : false;
    
        $jenisCuti->update($data);
    
        return redirect()->route('jenis-cuti.index')
                         ->with('success', 'Jenis cuti berhasil diperbarui.');
    }
}