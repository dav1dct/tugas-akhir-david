@extends('layouts.app')

@section('content')
<h1 style="font-family: 'Inter', sans-serif; font-weight: bold;" class="text-white text-center mb-4 h1 bg-gray-800 p-4">
    IMPORT DATA ABSENSI
</h1>
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('attendances.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="file" class="form-label fw-bold">Pilih File Excel / CSV</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                    <small class="text-muted">Format yang didukung: .xlsx, .xls, .csv</small>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Impor Data Absensi
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-4 alert alert-info">
        <strong>Catatan:</strong> Pastikan kolom di file Excel/CSV sesuai urutan: 
        <code>nik</code>, <code>nama</code>, <code>date</code>, <code>check_in</code>, <code>check_out</code>
    </div>
</div>
@endsection