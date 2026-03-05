@extends('layouts.app')

@section('content')
<h1 style="font-inter; font-weight: bold" class="text-white text-center mb-4 h1 bg-gray-800 p-4">DAFTAR KARYAWAN</h1>
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(auth()->user()->role === 'hsd')
    <a href="{{ route('karyawan.create') }}" class="btn btn-primary mb-3">Tambah Karyawan</a>
    @endif
    @if(in_array(auth()->user()->role, ['admin', 'hsd']))

    <div class="mb-3">
        <a href="{{ route('karyawan.export') }}" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Export ke Excel
        </a>
    </div>
    @endif
    <table class="table table-bordered border-2" style="border: 2px solid #0d6efd;">
        <thead class="align-middle text-center fw-bold fs-5" style="border: 2px solid #0d6efd;">
            <tr>
                <th style="width: 60px">No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Tanggal Lahir</th>
                <th>Pendidikan</th>
                <th>Posisi</th>
                <th>Departemen</th>
                <th>Status Kerja</th>
                <th>Status Pernikahan</th>
                <th>No Rekening</th>
                <th>Status</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Keluar</th>
                @if(auth()->user()->role === 'hsd')
                <th style="width: 1%; white-space: nowrap;">Aksi</th>
                @endif
            </tr>
        </thead>

        <tbody>
            @foreach($karyawans as $index => $k)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $k->nik }}</td>
                    <td>{{ $k->nama_lengkap }}</td>
                    <td>{{ $k->email }}</td>
                    <td class="text-center">{{ $k->no_hp }}</td>
                    <td class="text-center">{{ $k->alamat }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($k->tanggal_lahir)->format('d-m-Y') }}</td>
                    <td class="text-center">{{ $k->pendidikan }}</td>
                    <td class="text-center">{{ $k->posisi }}</td>
                    <td class="text-center">{{ $k->departemen }}</td>
                    <td class="text-center">{{ $k->status_kerja }}</td>
                    <td class="text-center">{{ $k->status_pernikahan }}</td>
                    <td class="text-center">{{ $k->no_rekening }}</td>
                    <td class="text-center">{{ $k->status }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($k->tanggal_masuk)->format('d-m-Y') }}</td>
                    <td class="text-center">
                        @if($k->tanggal_keluar)
                            {{ \Carbon\Carbon::parse($k->tanggal_keluar)->format('d-m-Y') }}
                        @else
                            -
                        @endif
                    </td>
                    @if(auth()->user()->role === 'hsd')
                        <td>
                            <a href="{{ route('karyawan.edit', $k) }}" class="btn btn-warning">Edit</a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
