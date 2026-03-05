@extends('layouts.app')

@section('content')
<h1 style="font-family: 'Inter', sans-serif; font-weight: bold;" class="text-white text-center mb-4 h1 bg-gray-800 p-4">
    AJUKAN CUTI
</h1>

    <!-- Notifikasi Sukses -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Notifikasi Error -->
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('leaves.store') }}">
        @csrf

        <div class="row g-4">
            <!-- Tanggal Mulai -->
            <div class="col-md-6">
                <label for="start_date" class="form-label text-black">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                @error('start_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tanggal Selesai -->
            <div class="col-md-6">
                <label for="end_date" class="form-label text-black">Tanggal Selesai</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                @error('end_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Jenis Cuti -->
            <div class="col-12">
                <label for="jenis_cuti" class="form-label text-black">Jenis Cuti</label>
                <select id="jenis_cuti" name="jenis_cuti" class="form-select" required>
                    <option value="" disabled {{ old('jenis_cuti') ? '' : 'selected' }}>Pilih Jenis Cuti</option>
                    <option value="tahunan" {{ old('jenis_cuti') == 'tahunan' ? 'selected' : '' }}>Cuti Tahunan</option>
                    <option value="sakit" {{ old('jenis_cuti') == 'sakit' ? 'selected' : '' }}>Cuti Sakit</option>
                    <option value="bersalin" {{ old('jenis_cuti') == 'bersalin' ? 'selected' : '' }}>Cuti Bersalin</option>
                    <option value="penting" {{ old('jenis_cuti') == 'penting' ? 'selected' : '' }}>Cuti Penting</option>
                    <option value="lainnya" {{ old('jenis_cuti') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('jenis_cuti')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Alasan -->
            <div class="col-12">
                <label for="alasan" class="form-label text-black">Alasan / Keterangan</label>
                <textarea id="alasan" name="alasan" rows="5" class="form-control" placeholder="Jelaskan alasan cuti secara singkat...">{{ old('alasan') }}</textarea>
                @error('alasan')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mt-5 text-end">
            <button type="button" class="btn btn-secondary me-3" onclick="history.back()">Batal</button>
            <button type="submit" class="btn btn-primary">Ajukan</button>
        </div>
    </form>
</div>
@endsection