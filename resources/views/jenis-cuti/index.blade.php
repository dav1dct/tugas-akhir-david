@extends('layouts.app')

@section('content')
<h1 style="font-family: 'Inter', sans-serif; font-weight: bold;" class="text-white text-center mb-4 h1 bg-gray-800 p-4">
    JENIS CUTI
</h1>

<div class="container">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tombol Tambah (hanya HSD) -->
    @if(auth()->user()->isHsd())
        <div class="mb-3">
            <a href="{{ route('jenis-cuti.create') }}" class="btn btn-primary">
                + Tambah Jenis Cuti
            </a>
        </div>
    @endif

    <table class="table table-bordered border-2" style="border: 2px solid #0d6efd;">
        <thead class="align-middle text-center fw-bold fs-5" style="border: 2px solid #0d6efd;">
            <tr>
                <th>Kode</th>
                <th>Deskripsi</th>
                <th>Durasi Maks (hari)</th>
                <th>Butuh Persetujuan</th>
                <th>Aktif</th>
                @if(auth()->user()->isHsd())
                    <th style="width: 1%; white-space: nowrap;">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($jenisCutis as $jenis)
                <tr class="{{ !$jenis->aktif ? 'table-secondary text-muted' : '' }}">
                    <td class="text-center">{{ $jenis->kode }}</td>
                    <td>{{ $jenis->deskripsi }}</td>
                    <td class="text-center">{{ $jenis->durasi_maks ?? '-' }}</td>
                    <td class="text-center">{{ $jenis->butuh_persetujuan ? 'Ya' : 'Tidak' }}</td>
                    <td class="text-center">
                        <span class="badge {{ $jenis->aktif ? 'bg-success' : 'bg-secondary' }}">
                            {{ $jenis->aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    @if(auth()->user()->isHsd())
                        <td class="text-center">
                            <a href="{{ route('jenis-cuti.edit', $jenis) }}" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ auth()->user()->isHsd() ? 6 : 5 }}" class="text-center py-4 text-muted">
                        Belum ada jenis cuti. Klik tombol di atas untuk menambahkan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection