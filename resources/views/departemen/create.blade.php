@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Departemen Baru</h1>

    <form action="{{ route('departemen.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Departemen <span class="text-danger">*</span></label>
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                   value="{{ old('nama') }}" required>
            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Kode (opsional)</label>
            <input type="text" name="kode" class="form-control" value="{{ old('kode') }}">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="aktif" class="form-check-input" id="aktif" checked>
            <label class="form-check-label" for="aktif">Aktif</label>
        </div>

        <button type="submit" class="btn btn-success">Simpan Departemen</button>
        <a href="{{ route('departemen.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection