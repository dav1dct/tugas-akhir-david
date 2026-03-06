@extends('layouts.app')

@section('content')
<h1 style="font-family: 'Inter', sans-serif; font-weight: bold;" class="text-white text-center mb-4 h1 bg-gray-800 p-4">
    EDIT JENIS CUTI
</h1>

<div class="container">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('jenis-cuti.update', $jenisCuti) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Kode -->
                    <div class="col-md-3">
                        <label for="kode" class="form-label fw-bold">Kode</label>
                        <input type="text" name="kode" id="kode" class="form-control" value="{{ old('kode', $jenisCuti->kode) }}" required maxlength="10">
                        @error('kode')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-md-9">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                        <input type="text" name="deskripsi" id="deskripsi" class="form-control" value="{{ old('deskripsi', $jenisCuti->deskripsi) }}" required>
                        @error('deskripsi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Durasi Maks -->
                    <div class="col-md-4">
                        <label for="durasi_maks" class="form-label fw-bold">Durasi Maksimal (hari)</label>
                        <input type="number" name="durasi_maks" id="durasi_maks" class="form-control" value="{{ old('durasi_maks', $jenisCuti->durasi_maks) }}" min="1">
                        @error('durasi_maks')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Kosongkan jika tidak ada batasan</small>
                    </div>

                    <!-- Aktif -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold d-block">Aktif</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="aktif" id="aktif" value="true" {{ old('aktif', $jenisCuti->aktif) ? 'checked' : '' }}>
                            <label class="form-check-label" for="aktif">Aktif (dapat dipilih saat pengajuan cuti)</label>
                        </div>
                    </div>

                    <!-- Butuh Persetujuan -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold d-block">Butuh Persetujuan</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="butuh_persetujuan" id="butuh_persetujuan" value="true" {{ old('butuh_persetujuan', $jenisCuti->butuh_persetujuan) ? 'checked' : '' }}>
                            <label class="form-check-label" for="butuh_persetujuan">Ya (memerlukan persetujuan HSD)</label>
                        </div>
                    </div>

                    <div class="mt-5 text-end">
                    <a href="{{ route('jenis-cuti.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection