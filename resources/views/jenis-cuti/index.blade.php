@extends('layouts.app')

@section('content')
<h1 style="font-family: 'Inter', sans-serif; font-weight: bold;" class="text-white text-center mb-4 h1 bg-gray-800 p-4">
    JENIS CUTI
</h1>

<div class="container-fluid px-4 py-4">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(auth()->user()->isHsd())
        <div class="mb-3">
            <a href="{{ route('jenis-cuti.create') }}" class="btn btn-primary">+ Tambah Jenis Cuti</a>
        </div>
    @endif

    <div class="card shadow-sm rounded-4" style="border: 2px solid #dee2e6;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Kode</th>
                            <th>Deskripsi</th>
                            <th>Durasi Maks (hari)</th>
                            <th>Butuh Persetujuan</th>
                            <th>Status</th>
                            @if(auth()->user()->isHsd())
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jenisCutis as $jenis)
                            <tr class="{{ !$jenis->aktif ? 'table-secondary text-muted' : '' }}">
                                <td>{{ $jenis->kode }}</td>
                                <td class="text-start">{{ $jenis->deskripsi }}</td>
                                <td>{{ $jenis->durasi_maks ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $jenis->butuh_persetujuan ? 'bg-primary' : 'bg-secondary' }}">
                                        {{ $jenis->butuh_persetujuan ? 'Ya' : 'Tidak' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $jenis->aktif ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $jenis->aktif ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                @if(auth()->user()->isHsd())
                                    <td>
                                        <a href="{{ route('jenis-cuti.edit', $jenis) }}" class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->isHsd() ? 6 : 5 }}" class="text-center py-4 text-muted fst-italic">
                                    Belum ada jenis cuti.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection