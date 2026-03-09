<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemens = Departemen::latest()->paginate(15);
        return view('departemen.index', compact('departemens'));
    }

    public function create()
    {
        return view('departemen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|unique:departemens,nama|max:100',
            'kode'      => 'nullable|unique:departemens,kode|max:20',
            'deskripsi' => 'nullable',
            'aktif'     => 'nullable|boolean'  // ← Pastikan sudah nullable
        ]);
        
        $validated['aktif'] = $request->has('aktif') ? true : false;  // ← Ubah jadi ini, lebih akurat

        Departemen::create($validated);

        return redirect()->route('departemen.index')
                         ->with('success', 'Departemen berhasil ditambahkan!');
    }

    public function edit(Departemen $departemen)
    {
        return view('departemen.edit', compact('departemen'));
    }

    public function update(Request $request, Departemen $departemen)
    {
        $validated = $request->validate([
            'nama'      => 'required|unique:departemens,nama,' . $departemen->id . '|max:100',
            'kode'      => 'nullable|unique:departemens,kode,' . $departemen->id . '|max:20',
            'deskripsi' => 'nullable',
            'aktif'     => 'nullable|boolean',
        ]);
    
        $validated['aktif'] = $request->has('aktif') ? true : false;
    
        $departemen->update($validated); // ← ini juga kurang sebelumnya!
    
        return redirect()->route('departemen.index')
                         ->with('success', 'Departemen berhasil diupdate!');
    }
}