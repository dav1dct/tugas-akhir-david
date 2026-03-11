@extends('layouts.app')

@section('content')
<h1 style="font-family: 'Inter', sans-serif; font-weight: bold;" class="text-white text-center mb-4 h1 bg-gray-800 p-4">
    DAFTAR ABSENSI
</h1>
<div class="container-fluid px-4 py-4">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Filter --}}
    <div class="card shadow-sm rounded-4 mb-4" style="border: 2px solid #dee2e6;">
        <div class="card-body">
            <form method="GET" action="{{ route('attendances.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" class="form-control" value="{{ request('nik') }}" placeholder="Cari NIK...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{ request('nama') }}" placeholder="Cari Nama...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button class="btn btn-primary w-100">Filter</button>
                        <a href="{{ route('attendances.index') }}" class="btn btn-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tombol Import --}}
    @if(auth()->user()->isHsd())
        <div class="mb-3">
            <a href="{{ route('attendances.importForm') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Impor dari Excel/CSV
            </a>
        </div>
    @endif

    {{-- Tabel --}}
    <div class="card shadow-sm rounded-4" style="border: 2px solid #dee2e6;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama Karyawan</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $index => $absen)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $absen->nik }}</td>
                                <td class="text-start">{{ $absen->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($absen->date)->format('d-m-Y') }}</td>
                                <td>
                                    @if($absen->check_in)
                                        <span class="badge bg-success">{{ $absen->check_in }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($absen->check_out)
                                        <span class="badge bg-secondary">{{ $absen->check_out }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted fst-italic">
                                    Belum ada data absensi.
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