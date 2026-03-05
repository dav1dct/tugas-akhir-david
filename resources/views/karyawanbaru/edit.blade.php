@extends('layouts.form')

@section('content')
    <h1 style="font-inter; font-weight: bold" class="text-white text-center mb-6 h1 bg-gray-800 p-4 rounded">EDIT KARYAWAN BARU</h1>

    <div class="w-full max-w-md mx-auto p-6 bg-gray-800 rounded shadow-md">
        <form action="{{ route('karyawanbaru.updateStatus', $karyawan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <x-input-label for="kode_lamaran" :value="__('Kode Lamaran')" />
                <x-text-input id="kode_lamaran" class="block mt-1 w-full bg-gray-700 text-black" type="text" name="kode_lamaran" :value="$karyawan->kode_lamaran" disabled />
            </div>
            <div class="mb-4">
                <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                <x-text-input id="nama_lengkap" class="block mt-1 w-full bg-gray-700 text-black" type="text" name="nama_lengkap" :value="$karyawan->nama_lengkap" disabled />
            </div>

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full bg-gray-700 text-black" type="email" name="email" :value="$karyawan->email" disabled />
            </div>

            <div class="mb-4">
                <x-input-label for="no_hp" :value="__('Nomor HP')" />
                <x-text-input id="no_hp" class="block mt-1 w-full bg-gray-700 text-black" type="text" name="no_hp" :value="$karyawan->no_hp" disabled />
            </div>

            <div class="mb-4">
                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                <x-text-input id="tanggal_lahir" class="block mt-1 w-full bg-gray-700 text-black" type="date" name="tanggal_lahir" :value="$karyawan->tanggal_lahir" disabled />
            </div>

            <div class="mb-4">
                <x-input-label for="pendidikan" :value="__('Pendidikan Terakhir')" />
                <input type="text" value="{{ $karyawan->pendidikan }}" class="block mt-1 w-full bg-gray-700 text-black" disabled>
            </div>

            <div class="mb-4">
                <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                <input type="text" value="{{ $karyawan->gender }}" class="block mt-1 w-full bg-gray-700 text-black" disabled>
            </div>

            <div class="mb-4">
                <x-input-label for="alamat" :value="__('Alamat')" />
                <textarea id="alamat" class="block mt-1 w-full bg-gray-700 text-black" rows="3" readonly>{{ $karyawan->alamat }}</textarea>
            </div>

            <div class="mb-4">
                <x-input-label for="status" :value="__('Status')" />
                <select name="status" id="status" class="block mt-1 w-full rounded border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-white" required>
                    @foreach(['Menunggu', 'Diterima', 'Ditolak'] as $status)
                        <option value="{{ $status }}" {{ $karyawan->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end mt-6">
                <x-primary-button>
                    {{ __('Simpan Perubahan') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection
