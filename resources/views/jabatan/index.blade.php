@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Data Jabatan</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('jabatan.create') }}" class="btn btn-primary mb-3">+ Tambah Jabatan</a>

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
            @foreach ($jabatans as $j)
            <tr>
                <td>{{ $j->nama }}</td>
                <td>
                    <strong>{{ $j->departemen?->nama ?? '<span class="text-muted">Belum diatur</span>' }}</strong>
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
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $jabatans->links() }}
</div>
@endsection