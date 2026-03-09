<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Departemen;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::with('departemen')->latest()->paginate(15);
        return view('jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        $departemens = Departemen::where('aktif', true)->orderBy('nama')->get();
        return view('jabatan.create', compact('departemens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|max:100',
            'departemen_id' => 'required|exists:departemens,id',
            'deskripsi'     => 'nullable',
            'aktif'         => 'nullable|boolean'  // ← Pastikan nullable
        ]);

        $validated['aktif'] = $request->has('aktif') ? true : false;  // ← Ubah jadi ini

        if (Jabatan::where('nama', $validated['nama'])
                    ->where('departemen_id', $validated['departemen_id'])
                    ->exists()) {
            return back()->withErrors(['nama' => 'Jabatan ini sudah ada di departemen tersebut.'])->withInput();
        }

        Jabatan::create($validated);

        return redirect()->route('jabatan.index')
                         ->with('success', 'Jabatan berhasil ditambahkan!');
    }

    public function edit(Jabatan $jabatan)
    {
        $departemens = Departemen::where('aktif', true)->orderBy('nama')->get();
        return view('jabatan.edit', compact('jabatan', 'departemens'));
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $validated = $request->validate([
            'nama'          => 'required|max:100',
            'departemen_id' => 'required|exists:departemens,id',
            'deskripsi'     => 'nullable',
            'aktif'         => 'nullable|boolean',
        ]);
    
        if (Jabatan::where('nama', $validated['nama'])
                    ->where('departemen_id', $validated['departemen_id'])
                    ->where('id', '!=', $jabatan->id)
                    ->exists()) {
            return back()->withErrors(['nama' => 'Jabatan ini sudah ada di departemen tersebut.'])->withInput();
        }
    
        $validated['aktif'] = $request->has('aktif') ? true : false;
    
        $jabatan->update($validated); // ← ini yang kurang!
    
        return redirect()->route('jabatan.index')
                         ->with('success', 'Jabatan berhasil diupdate!');
    }
}