@extends('layouts.app')

@section('content')
<h1 style="font-family: 'Inter', sans-serif; font-weight: bold;" class="text-white text-center mb-4 h1 bg-gray-800 p-4">
    TAMBAH KARYAWAN
</h1>
<div class="container">

    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('karyawan.store') }}" method="POST">
        @csrf

        <!-- NIK -->
        <div class="mb-3">
            <label class="form-label">NIK</label>
            <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" required>
            @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Nama Lengkap -->
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- No HP -->
        <div class="mb-3">
            <label class="form-label">No HP</label>
            <input type="number" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
        </div>

        <!-- Alamat -->
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ old('alamat') }}</textarea>
        </div>

        <!-- Tanggal Lahir -->
        <div class="mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
        </div>

        <!-- Pendidikan -->
        <div class="mb-3">
            <label class="form-label">Pendidikan Terakhir</label>
            <select name="pendidikan" class="form-select" required>
                <option value="">-- Pilih Pendidikan --</option>
                @foreach(['SD', 'SMP', 'SMA', 'SMK', 'D3', 'S1', 'S2', 'S3', 'Lainnya'] as $jenjang)
                    <option value="{{ $jenjang }}" {{ old('pendidikan') == $jenjang ? 'selected' : '' }}>{{ $jenjang }}</option>
                @endforeach
            </select>
        </div>

        <!-- Departemen (dari database) -->
        <div class="mb-3">
            <label class="form-label">Departemen <span class="text-danger">*</span></label>
            <select name="departemen_id" id="departemen_id" class="form-select @error('departemen_id') is-invalid @enderror" required>
                <option value="">-- Pilih Departemen --</option>
                @foreach ($departemens as $d)
                    <option value="{{ $d->id }}"
                        {{ old('departemen_id') == $d->id ? 'selected' : '' }}
                        {{ !$d->aktif ? 'disabled' : '' }}
                        style="{{ !$d->aktif ? 'color: #aaa;' : '' }}">
                        {{ $d->nama }}{{ !$d->aktif ? ' (Nonaktif)' : '' }}
                    </option>
                @endforeach
            </select>
            @error('departemen_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Jabatan (dari database) -->
        <div class="mb-3">
            <label class="form-label">Jabatan <span class="text-danger">*</span></label>
            <select name="jabatan_id" id="jabatan_id" class="form-select @error('jabatan_id') is-invalid @enderror" required>
                <option value="">-- Pilih Jabatan --</option>
                @foreach ($jabatans as $j)
                    <option value="{{ $j->id }}"
                        data-departemen="{{ $j->departemen_id }}"
                        {{ old('jabatan_id') == $j->id ? 'selected' : '' }}
                        {{ !$j->aktif ? 'disabled' : '' }}
                        style="{{ !$j->aktif ? 'color: #aaa;' : '' }}">
                        {{ $j->nama }}{{ !$j->aktif ? ' (Nonaktif)' : '' }}
                    </option>
                @endforeach
            </select>
            @error('jabatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Status Kerja -->
        <div class="mb-3">
            <label class="form-label">Status Kerja</label>
            <select name="status_kerja" class="form-select" required>
                <option value="Tetap" {{ old('status_kerja') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                <option value="Tidak Tetap" {{ old('status_kerja') == 'Tidak Tetap' ? 'selected' : '' }}>Tidak Tetap</option>
            </select>
        </div>

        <!-- Status Pernikahan -->
        <div class="mb-3">
            <label class="form-label">Status Pernikahan</label>
            <select name="status_pernikahan" class="form-select" required>
                <option value="Nikah" {{ old('status_pernikahan') == 'Nikah' ? 'selected' : '' }}>Nikah</option>
                <option value="Tidak Nikah" {{ old('status_pernikahan') == 'Tidak Nikah' ? 'selected' : '' }}>Tidak Nikah</option>
            </select>
        </div>

        <!-- No Rekening -->
        <div class="mb-3">
            <label class="form-label">No Rekening</label>
            <input type="text" name="no_rekening" class="form-control @error('no_rekening') is-invalid @enderror" value="{{ old('no_rekening') }}" required>
            @error('no_rekening') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                <option value="Menunggu" {{ old('status', 'Menunggu') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
            </select>
        </div>

        <!-- Tanggal Masuk -->
        <div class="mb-3">
            <label class="form-label">Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk') }}" required>
        </div>

        <!-- Tanggal Keluar -->
        <div class="mb-3">
            <label class="form-label">Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" class="form-control" value="{{ old('tanggal_keluar') }}">
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<script>
    const departemenSelect = document.getElementById('departemen_id');
    const jabatanSelect = document.getElementById('jabatan_id');
    const allJabatanOptions = Array.from(jabatanSelect.options);

    function filterJabatan(selectedDepartemenId) {
        jabatanSelect.innerHTML = '<option value="">-- Pilih Jabatan --</option>';
        allJabatanOptions.forEach(option => {
            if (option.value === '') return;
            if (!selectedDepartemenId || option.dataset.departemen == selectedDepartemenId) {
                jabatanSelect.appendChild(option.cloneNode(true));
            }
        });
    }

    // Filter saat pertama load (untuk old() setelah validation error)
    filterJabatan(departemenSelect.value);

    departemenSelect.addEventListener('change', function () {
        filterJabatan(this.value);
    });
</script>

@endsection