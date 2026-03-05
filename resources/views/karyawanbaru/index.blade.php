@extends('layouts.app')

@section('content')
<h1 class="text-white text-center mb-4 h1 bg-gray-800 p-4" style="font-family: Inter; font-weight: bold;">
    DAFTAR KARYAWAN BARU
</h1>
<div class="container">
    @if(in_array(auth()->user()->role, ['admin', 'hsd']))
        <div class="mb-3">
            <a href="{{ route('karyawanbaru.export') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export ke Excel
            </a>
        </div>
    @endif
    <table class="table table-bordered border-2" style="border: 2px solid #0d6efd;">
        <thead class="align-middle text-center fw-bold fs-5" style="border: 2px solid #0d6efd;">
            <tr>
                <th style="width: 60px">No</th>
                <th>Kode Lamaran</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Tanggal Lahir</th>
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
            @foreach($karyawanbarus as $index => $kb)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $kb->kode_lamaran }}</td>
                    <td>{{ $kb->nama_lengkap }}</td>
                    <td>{{ $kb->email }}</td>
                    <td>{{ $kb->no_hp }}</td>
                    <td>{{ \Carbon\Carbon::parse($kb->tanggal_lahir)->format('d-m-Y') }}</td>
                    <td>{{ $kb->pendidikan }}</td>
                    <td>{{ $kb->gender }}</td>
                    <td>{{ $kb->alamat }}</td>
                    <td>{{ $kb->status }}</td>

                    {{-- Surat Lamaran --}}
                    <td>
                        <a href="{{ route('karyawanbaru.download', [$kb->id, 'surat_lamaran']) }}" class="btn btn-info btn-sm">
                            Download
                        </a>
                    </td>

                    {{-- Foto Identitas --}}
                    <td class="text-center">
                        <img src="{{ route('karyawanbaru.image', [$kb->id, 'foto_identitas']) }}"
                             alt="Foto Identitas" width="50" class="img-fluid mb-1 rounded">
                        <br>
                        <a href="{{ route('karyawanbaru.download', [$kb->id, 'foto_identitas']) }}"
                           class="btn btn-sm btn-info mt-1">
                            Download
                        </a>
                    </td>

                    {{-- CV --}}
                    <td>
                        <a href="{{ route('karyawanbaru.download', [$kb->id, 'cv']) }}" class="btn btn-info btn-sm">
                            Download
                        </a>
                    </td>

                    {{-- Ijazah --}}
                    <td>
                        <a href="{{ route('karyawanbaru.download', [$kb->id, 'ijazah']) }}" class="btn btn-info btn-sm">
                            Download
                        </a>
                    </td>

                    @if(in_array(auth()->user()->role, ['hsd']))
                        <td>
                            <a href="{{ route('karyawanbaru.edit', $kb) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
