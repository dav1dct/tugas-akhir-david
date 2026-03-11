@extends('layouts.app')

@section('content')
<h1 style="font-family: 'Inter', sans-serif; font-weight: bold;" class="text-white text-center mb-4 h1 bg-gray-800 p-4">
    DAFTAR KARYAWAN
</h1>
<div class="container-fluid px-4 py-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(auth()->user()->isKaryawan())
        <div class="alert alert-info mb-3">
            <i class="fas fa-info-circle"></i>
            <strong>Ini adalah data Anda.</strong>
        </div>
    @endif

    <div class="d-flex gap-2 mb-3">
        @if(auth()->user()->role === 'hsd')
            <a href="{{ route('karyawan.create') }}" class="btn btn-primary">+ Tambah Karyawan</a>
        @endif
        @if(in_array(auth()->user()->role, ['admin', 'hsd']))
            <a href="{{ route('karyawan.export') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export ke Excel
            </a>
        @endif
    </div>

    <div class="card shadow-sm rounded-4" style="border: 2px solid #dee2e6;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Tgl Lahir</th>
                            <th>Pendidikan</th>
                            <th>Jabatan</th>
                            <th>Departemen</th>
                            <th>Status Kerja</th>
                            <th>Status Nikah</th>
                            <th>No Rekening</th>
                            <th>Status</th>
                            <th>Tgl Masuk</th>
                            <th>Tgl Keluar</th>
                            @if(auth()->user()->role === 'hsd')
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($karyawans as $index => $k)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $k->nik }}</td>
                                <td class="text-start">{{ $k->nama_lengkap }}</td>
                                <td class="text-start">{{ $k->email }}</td>
                                <td>{{ $k->no_hp }}</td>
                                <td class="text-start">{{ $k->alamat }}</td>
                                <td>{{ \Carbon\Carbon::parse($k->tanggal_lahir)->format('d-m-Y') }}</td>
                                <td>{{ $k->pendidikan }}</td>
                                <td>{{ $k->jabatan?->nama ?? '-' }}</td>
                                <td>{{ $k->departemen?->nama ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $k->status_kerja === 'Tetap' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $k->status_kerja }}
                                    </span>
                                </td>
                                <td>{{ $k->status_pernikahan }}</td>
                                <td>{{ $k->no_rekening }}</td>
                                <td>
                                    @if($k->status === 'Aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($k->status === 'Tidak Aktif')
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($k->tanggal_masuk)->format('d-m-Y') }}</td>
                                <td>{{ $k->tanggal_keluar ? \Carbon\Carbon::parse($k->tanggal_keluar)->format('d-m-Y') : '-' }}</td>
                                @if(auth()->user()->role === 'hsd')
                                    <td>
                                        <a href="{{ route('karyawan.edit', $k) }}" class="btn btn-warning btn-sm">Edit</a>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'hsd' ? 17 : 16 }}" class="text-center py-4 text-muted fst-italic">
                                    Belum ada data karyawan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection