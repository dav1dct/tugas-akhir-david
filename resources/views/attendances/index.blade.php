@extends('layouts.app')

@section('content')
<h1 style="font-family: 'Inter', sans-serif; font-weight: bold;" class="text-white text-center mb-4 h1 bg-gray-800 p-4">
    DAFTAR ABSENSI
</h1>
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('attendances.index') }}">
            <div class="row">

                <div class="col-md-3">
                    <label>NIK</label>
                    <input type="text" name="nik" class="form-control"
                        value="{{ request('nik') }}">
                </div>

                <div class="col-md-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control"
                        value="{{ request('nama') }}">
                </div>

                <div class="col-md-2">
                    <label>Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control"
                        value="{{ request('start_date') }}">
                </div>

                <div class="col-md-2">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control"
                        value="{{ request('end_date') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary me-2">
                        Filter
                    </button>

                    <a href="{{ route('attendances.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Tombol Impor (hanya HSD) -->
    @if(auth()->user()->isHsd())
        <a href="{{ route('attendances.importForm') }}" class="btn btn-success mb-3">
            <i class="fas fa-file-excel"></i> Impor dari Excel/CSV
        </a>
    @endif

    @if($attendances->isEmpty())
        <div class="alert alert-info text-center">
            Belum ada data absensi.
        </div>
    @else
        <table class="table table-bordered border-2" style="border: 2px solid #0d6efd;">
            <thead class="align-middle text-center fw-bold" style="border: 2px solid #0d6efd;">
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
            @foreach($attendances as $index => $absen)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $absen->nik }}</td>
                <td>{{ $absen->nama }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($absen->date)->format('d-m-Y') }}</td>
                <td class="text-center">{{ $absen->check_in ?? '-' }}</td>
                <td class="text-center">{{ $absen->check_out ?? '-' }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection