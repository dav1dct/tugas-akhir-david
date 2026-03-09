@extends('layouts.app')

@section('content')
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
    <h1>Edit Departemen</h1>

    <form action="{{ route('departemen.update', $departemen) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Departemen <span class="text-danger">*</span></label>
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                   value="{{ old('nama', $departemen->nama) }}" required>
            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Kode (opsional)</label>
            <input type="text" name="kode" class="form-control" value="{{ old('kode', $departemen->kode) }}">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $departemen->deskripsi) }}</textarea>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="aktif" value="1" class="form-check-input" id="aktif" 
                {{ old('aktif', $departemen->aktif) ? 'checked' : '' }}>
            <label class="form-check-label" for="aktif">Aktif</label>
        </div>

        <button type="submit" class="btn btn-success">Update Departemen</button>
        <a href="{{ route('departemen.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection