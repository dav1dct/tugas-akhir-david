@extends('layouts.app')

@section('content')
<h1 style="font-family: 'Inter', sans-serif; font-weight: bold;" class="text-white text-center mb-4 h1 bg-gray-800 p-4">
    TAMBAH JENIS CUTI
</h1>

<div class="container">
    <form method="POST" action="{{ route('jenis-cuti.store') }}">
        @csrf

        <div class="row g-3">
            <div class="col-md-3">
                <label for="kode" class="form-label">Kode</label>
                <input type="text" name="kode" class="form-control" value="{{ old('kode') }}" required maxlength="10">
                @error('kode') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <input type="text" name="deskripsi" class="form-control" value="{{ old('deskripsi') }}" required>
                @error('deskripsi') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-3">
                <label for="durasi_maks" class="form-label">Durasi Maks (hari)</label>
                <input type="number" name="durasi_maks" class="form-control" value="{{ old('durasi_maks') }}" min="1">
                @error('durasi_maks') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Butuh Persetujuan</label>
                <select name="butuh_persetujuan" class="form-select">
                    <option value="1" {{ old('butuh_persetujuan', 1) ? 'selected' : '' }}>Ya</option>
                    <option value="0" {{ old('butuh_persetujuan') === '0' ? 'selected' : '' }}>Tidak</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Aktif</label>
                <select name="aktif" class="form-select">
                    <option value="1" {{ old('aktif', 1) ? 'selected' : '' }}>Ya</option>
                    <option value="0" {{ old('aktif') === '0' ? 'selected' : '' }}>Tidak</option>
                </select>
            </div>
        </div>

        <div class="mt-4 text-end">
            <a href="{{ route('jenis-cuti.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection