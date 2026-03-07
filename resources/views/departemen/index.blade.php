@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Data Departemen</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('departemen.create') }}" class="btn btn-primary mb-3">+ Tambah Departemen</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nama Departemen</th>
                <th>Kode</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departemen as $d)
            <tr>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->kode ?? '-' }}</td>
                <td>{{ $d->deskripsi ? substr($d->deskripsi, 0, 80) . '...' : '-' }}</td>
                <td>
                    @if ($d->aktif)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Non-Aktif</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $departemen->links() }}
</div>
@endsection