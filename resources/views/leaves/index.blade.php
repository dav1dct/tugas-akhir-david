@extends('layouts.app')

@section('content')
<h1 style="font-family: 'Inter', sans-serif; font-weight: bold;" class="text-white text-center mb-4 h1 bg-gray-800 p-4">
    DAFTAR PENGAJUAN CUTI
</h1>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Ajukan Cuti Baru (hanya karyawan) -->
    @if(auth()->user()->isKaryawan())
        <a href="{{ route('leaves.create') }}" class="btn btn-primary mb-3">
            Ajukan Cuti Baru
        </a>
    @endif

    <!-- Placeholder kalau kosong -->
    @if($leaves->isEmpty())
        <div class="text-center py-5 bg-light rounded shadow-sm">
            <h4 class="text-muted">Daftar cuti masih kosong</h4>
            <p class="text-secondary">
                @if(auth()->user()->isKaryawan())
                    Anda belum mengajukan cuti apa pun. Klik tombol di atas untuk mulai.
                @elseif(auth()->user()->isHsd())
                    Belum ada karyawan yang mengajukan cuti. Tunggu pengajuan masuk.
                @else
                    Belum ada pengajuan cuti dari seluruh karyawan. Anda bisa memantau daftar ini.
                @endif
            </p>
        </div>
    @else
        <!-- Table kalau ada data -->
        <table class="table table-bordered border-2" style="border: 2px solid #0d6efd;">
            <thead class="align-middle text-center fw-bold fs-5" style="border: 2px solid #0d6efd;">
                <tr>
                    <th style="width: 60px">No</th>
                    <th>Karyawan</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Jenis Cuti</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    @if(auth()->user()->isHsd())
                        <th style="width: 1%; white-space: nowrap;">Aksi</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @foreach($leaves as $index => $leave)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $leave->karyawan->nama_lengkap ?? 'Tidak ditemukan' }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($leave->start_date)->format('d-m-Y') }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($leave->end_date)->format('d-m-Y') }}</td>
                        <td class="text-center capitalize">{{ $leave->jenis_cuti }}</td>
                        <td>{{ $leave->alasan ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge 
                                {{ $leave->status == 'pending' ? 'bg-warning text-dark' : '' }}
                                {{ $leave->status == 'approved' ? 'bg-success text-white' : '' }}
                                {{ $leave->status == 'rejected' ? 'bg-danger text-white' : '' }}">
                                {{ ucfirst($leave->status) }}
                            </span>
                        </td>

                        @if(auth()->user()->isHsd() && $leave->status == 'pending')
                            <td class="text-center">
                                <form action="{{ route('leaves.updateStatus', $leave) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                </form>

                                <form action="{{ route('leaves.updateStatus', $leave) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                </form>
                            </td>
                        @elseif(auth()->user()->isHsd())
                            <td class="text-center">-</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection