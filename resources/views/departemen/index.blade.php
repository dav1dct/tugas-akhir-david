@extends('layouts.app')

@section('content')
<h1 style="font-family: 'Inter', sans-serif; font-weight: bold;" class="text-white text-center mb-4 h1 bg-gray-800 p-4">
    DATA DEPARTEMEN
</h1>
<div class="container">
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
    <a href="{{ route('departemen.create') }}" class="btn btn-primary mb-3">+ Tambah Departemen</a>
    @endif
    
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
            @if ($departemens->isEmpty())
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-600">Tidak ada data departemen</td>
                </tr>
            @else
                @foreach ($departemens as $d)
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
                    <td>
                        @if (auth()->user()->role === 'hsd')
                            <a href="{{ route('departemen.edit', $d) }}" class="btn btn-sm btn-warning">Edit</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    {{ $departemens->links() }}
</div>
@endsection