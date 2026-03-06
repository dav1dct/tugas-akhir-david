@extends('layouts.app')

@section('content')
<h1 style="font-family: 'Inter', sans-serif; font-weight: bold;" class="text-white text-center mb-4 h1 bg-gray-800 p-4">
    AJUKAN CUTI
</h1>

<div class="container">
    <!-- Tampilkan semua error validasi -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Ada kesalahan!</strong> Silakan periksa kembali form Anda.
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
                <label for="jenis_cuti_id" class="form-label text-black">Jenis Cuti</label>
                <select id="jenis_cuti_id" name="jenis_cuti_id" class="form-select" required>
                    <option value="">Pilih Jenis Cuti</option>
                    @foreach(\App\Models\JenisCuti::orderBy('kode')->get() as $jenis)  <!-- tampilkan SEMUA, urut kode -->
                        <option value="{{ $jenis->id }}"
                                {{ old('jenis_cuti_id') == $jenis->id ? 'selected' : '' }}
                                {{ !$jenis->aktif ? 'disabled' : '' }}
                                style="{{ !$jenis->aktif ? 'color: #6c757d; background-color: #f8f9fa; font-style: italic;' : '' }}">
                            {{ $jenis->kode }} - {{ $jenis->deskripsi }}
                            (Maks: {{ $jenis->durasi_maks ?? 'Tidak ada batas' }} hari)
                            {{ !$jenis->aktif ? '(Nonaktif)' : '' }}
                        </option>
                    @endforeach
                </select>
                @error('jenis_cuti_id')
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