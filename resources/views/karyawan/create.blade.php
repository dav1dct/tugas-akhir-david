@extends('layouts.app')

@section('content')
<h1 style="font-inter; font-weight: bold" class="text-white text-center mb-4 h1 bg-gray-800 p-4">TAMBAH KARYAWAN</h1>
<div class="container">
    <form action="{{ route('karyawan.store') }}" method="POST">
        @csrf

        <!-- NIK -->
        <div class="mb-3">
            <label class="text-black dark:text-white">NIK</label>
            <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" required>
            @error('nik')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Nama Lengkap -->
        <div class="mb-3">
            <label class="text-black dark:text-white">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label class="text-black dark:text-white">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- No HP -->
        <div class="mb-3">
            <label class="text-black dark:text-white">No HP</label>
            <input type="number" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
        </div>

        <!-- Alamat -->
        <div class="mb-3">
            <label class="text-black dark:text-white">Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ old('alamat') }}</textarea>
        </div>

        <!-- Tanggal Lahir -->
        <div class="mb-3">
            <label class="text-black dark:text-white">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
        </div>

        <!-- Pendidikan -->
        <div class="mb-4">
            <label class="text-black dark:text-white">Pendidikan Terakhir</label>
            <select name="pendidikan" id="pendidikan" class="block mt-1 w-full rounded border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-white" style="background-color: white; color: black; border: 1px solid #ccc;" required>
                <option value="">-- Pilih Pendidikan Terakhir --</option>
                @foreach(['SD', 'SMP', 'SMA', 'SMK', 'D3', 'S1', 'S2', 'S3', 'Lainnya'] as $jenjang)
                    <option value="{{ $jenjang }}" {{ old('pendidikan') == $jenjang ? 'selected' : '' }}>{{ $jenjang }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('pendidikan')" class="mt-2" />
        </div>

        <!-- Posisi -->
        <div class="mb-3">
            <label class="text-black dark:text-white">Posisi</label>
            <select name="posisi" class="form-control">
                <option value="Manager" {{ old('posisi') == 'Manager' ? 'selected' : '' }}>Manager</option>
                <option value="Staff" {{ old('posisi') == 'Staff' ? 'selected' : '' }}>Staff</option>
            </select>
        </div>

        <!-- Departemen -->
        <div class="mb-3">
            <label class="text-black dark:text-white">Departemen</label>
            <select name="departemen" class="form-control">
                <option value="HRD" {{ old('departemen') == 'HRD' ? 'selected' : '' }}>HRD</option>
                <option value="IT" {{ old('departemen') == 'IT' ? 'selected' : '' }}>IT</option>
            </select>
        </div>

        <!-- Status Kerja -->
        <div class="mb-3">
            <label class="text-black dark:text-white">Status Kerja</label>
            <select name="status_kerja" class="form-control" required>
                <option value="Tetap" {{ old('status_kerja') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                <option value="Tidak Tetap" {{ old('status_kerja') == 'Tidak Tetap' ? 'selected' : '' }}>Tidak Tetap</option>
            </select>
        </div>

        <!-- Status Pernikahan -->
        <div class="mb-3">
            <label class="text-black dark:text-white">Status Pernikahan</label>
            <select name="status_pernikahan" class="form-control" required>
                <option value="Nikah" {{ old('status_pernikahan') == 'Nikah' ? 'selected' : '' }}>Nikah</option>
                <option value="Tidak Nikah" {{ old('status_pernikahan') == 'Tidak Nikah' ? 'selected' : '' }}>Tidak Nikah</option>
            </select>
        </div>

        <!-- No Rekening -->
        <div class="mb-3">
            <label class="text-black dark:text-white">No Rekening</label>
            <input type="text" name="no_rekening" class="form-control" value="{{ old('no_rekening') }}" required>
            @error('no_rekening')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label class="text-black dark:text-white">Status</label>
            <select name="status" class="form-control" required>
                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                <option value="Menunggu" {{ old('status', 'Menunggu') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
            </select>
        </div>

        <!-- Tanggal Masuk -->
        <div class="mb-3">
            <label class="text-black dark:text-white">Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk') }}" required>
        </div>

        <!-- Tanggal Keluar -->
        <div class="mb-3">
            <label class="text-black dark:text-white">Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" class="form-control" value="{{ old('tanggal_keluar') }}">
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
