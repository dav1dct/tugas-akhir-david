@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Data Jabatan</h1>

    @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (auth()->user()->role === 'hsd')
    <a href="{{ route('jabatan.create') }}" class="btn btn-primary mb-3">+ Tambah Jabatan</a>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nama Jabatan</th>
                <th>Departemen</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
    @forelse ($jabatans as $j)
    <tr>
        <td>{{ $j->nama }}</td>
        <td>
            <strong>{!! $j->departemen?->nama ?? '<span class="text-muted">Belum diatur</span>' !!}</strong>
        </td>
        <td>
            {{ $j->deskripsi ? substr($j->deskripsi, 0, 80) . '...' : '-' }}
        </td>
        <td>
            @if ($j->aktif)
                <span class="badge bg-success">Aktif</span>
            @else
                <span class="badge bg-secondary">Non-Aktif</span>
            @endif
        </td>
        <td>
            @if (auth()->user()->role === 'hsd')
                <a href="{{ route('jabatan.edit', $j) }}" class="btn btn-sm btn-warning">Edit</a>
            @endif
        </td>
    </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center py-4 text-muted fst-italic">
                Belum ada data jabatan.
            </td>
        </tr>
    @endforelse
</tbody>
    </table>

    {{ $jabatans->links() }}
</div>
@endsection