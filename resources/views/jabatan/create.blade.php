@extends('layouts.app')

@section('content')
<h1 style="font-family: 'Inter', sans-serif; font-weight: bold;" class="text-white text-center mb-4 h1 bg-gray-800 p-4">
    TAMBAH JABATAN BARU
</h1>
<div class="container">
    @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jabatan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Departemen <span class="text-danger">*</span></label>
            <select name="departemen_id" class="form-select @error('departemen_id') is-invalid @enderror" required>
                <option value="">-- Pilih Departemen --</option>
                @foreach ($departemens as $d)
                    <option value="{{ $d->id }}" {{ old('departemen_id') == $d->id ? 'selected' : '' }}>
                        {{ $d->nama }}
                    </option>
                @endforeach
            </select>
            @error('departemen_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Nama Jabatan <span class="text-danger">*</span></label>
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                   value="{{ old('nama') }}" required>
            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="aktif" value="1" class="form-check-input" id="aktif" {{ old('aktif', 1) ? 'checked' : '' }}>
            <label class="form-check-label" for="aktif">Aktif</label>
        </div>

        <button type="submit" class="btn btn-success">Simpan Jabatan</button>
        <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection