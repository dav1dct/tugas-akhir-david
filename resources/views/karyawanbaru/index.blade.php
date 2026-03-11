@extends('layouts.app')

@section('content')
<h1 style="font-family: 'Inter', sans-serif; font-weight: bold;" class="text-white text-center mb-4 h1 bg-gray-800 p-4">
    DAFTAR KARYAWAN BARU
</h1>
<div class="container-fluid px-4 py-4">
    <div class="d-flex gap-2 mb-3">
        @if(in_array(auth()->user()->role, ['admin', 'hsd']))
            <a href="{{ route('karyawanbaru.export') }}" class="btn btn-success">
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
                            <th>Kode Lamaran</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Tgl Lahir</th>
                            <th>Pendidikan</th>
                            <th>Gender</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Surat Lamaran</th>
                            <th>Foto Identitas</th>
                            <th>CV</th>
                            <th>Ijazah</th>
                            @if(in_array(auth()->user()->role, ['hsd']))
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($karyawanbarus as $index => $kb)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $kb->kode_lamaran }}</td>
                                <td class="text-start">{{ $kb->nama_lengkap }}</td>
                                <td class="text-start">{{ $kb->email }}</td>
                                <td>{{ $kb->no_hp }}</td>
                                <td>{{ \Carbon\Carbon::parse($kb->tanggal_lahir)->format('d-m-Y') }}</td>
                                <td>{{ $kb->pendidikan }}</td>
                                <td>{{ $kb->gender }}</td>
                                <td class="text-start">{{ $kb->alamat }}</td>
                                <td>
                                    @if($kb->status === 'Diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @elseif($kb->status === 'Ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('karyawanbaru.download', [$kb->id, 'surat_lamaran']) }}" class="btn btn-info btn-sm">
                                        Download
                                    </a>
                                </td>
                                <td>
                                    <img src="{{ route('karyawanbaru.image', [$kb->id, 'foto_identitas']) }}"
                                         alt="Foto" width="50" class="img-fluid rounded mb-1">
                                    <br>
                                    <a href="{{ route('karyawanbaru.download', [$kb->id, 'foto_identitas']) }}" class="btn btn-info btn-sm mt-1">
                                        Download
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('karyawanbaru.download', [$kb->id, 'cv']) }}" class="btn btn-info btn-sm">
                                        Download
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('karyawanbaru.download', [$kb->id, 'ijazah']) }}" class="btn btn-info btn-sm">
                                        Download
                                    </a>
                                </td>
                                @if(in_array(auth()->user()->role, ['hsd']))
                                    <td>
                                        <a href="{{ route('karyawanbaru.edit', $kb) }}" class="btn btn-warning btn-sm">Edit</a>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ in_array(auth()->user()->role, ['hsd']) ? 15 : 14 }}" class="text-center py-4 text-muted fst-italic">
                                    Belum ada data karyawan baru.
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