<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemen = Departemen::latest()->paginate(15);
        return view('departemen.index', compact('departemen'));
    }

    public function create()
    {
        return view('departemen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|unique:departemen,nama|max:100',
            'kode'      => 'nullable|unique:departemen,kode|max:20',
            'deskripsi' => 'nullable',
            'aktif'     => 'boolean'
        ]);

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
            'nama'      => 'required|unique:departemen,nama,' . $departemen->id . '|max:100',
            'kode'      => 'nullable|unique:departemen,kode,' . $departemen->id . '|max:20',
            'deskripsi' => 'nullable',
            'aktif'     => 'boolean'
        ]);

        $departemen->update($validated);

        return redirect()->route('departemen.index')
                         ->with('success', 'Departemen berhasil diupdate!');
    }
}