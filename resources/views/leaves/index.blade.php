@extends('layouts.app')

@section('content')
<h1 style="font-family: 'Inter', sans-serif; font-weight: bold;" class="text-white text-center mb-4 h1 bg-gray-800 p-4">
    DAFTAR PENGAJUAN CUTI
</h1>

<div class="container-fluid px-4 py-4">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter --}}
    <div class="card shadow-sm rounded-4 mb-4" style="border: 2px solid #dee2e6;">
        <div class="card-body">
            <form method="GET" action="{{ route('leaves.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Jenis Cuti</label>
                    <select name="jenis_cuti_id" class="form-select">
                        <option value="">Semua Jenis</option>
                        @foreach ($jenisCutis as $jenis)
                            <option value="{{ $jenis->id }}" {{ request('jenis_cuti_id') == $jenis->id ? 'selected' : '' }}
                                style="{{ !$jenis->aktif ? 'color: #6c757d; font-style: italic;' : '' }}">
                                {{ $jenis->kode }} - {{ $jenis->deskripsi }}
                                (Maks: {{ $jenis->durasi_maks ?? 'Tidak ada batas' }} hari)
                                {{ !$jenis->aktif ? '(Nonaktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Selesai</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                    <a href="{{ route('leaves.index') }}" class="btn btn-secondary w-100">Clear</a>
                </div>
            </form>
        </div>
    </div>

    @if(auth()->user()->isKaryawan())
        <div class="mb-3">
            <a href="{{ route('leaves.create') }}" class="btn btn-primary">+ Ajukan Cuti Baru</a>
        </div>
    @endif

    {{-- Tabel --}}
    <div class="card shadow-sm rounded-4" style="border: 2px solid #dee2e6;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Karyawan</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Jenis Cuti</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Catatan Penolakan</th>
                            @if(auth()->user()->isHsd())
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $index => $leave)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-start">{{ $leave->karyawan->nama_lengkap ?? 'Tidak ditemukan' }}</td>
                                <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d-m-Y') }}</td>
                                <td>{{ $leave->jenisCuti->kode ?? ucfirst($leave->jenis_cuti ?? '-') }}</td>
                                <td class="text-start">{{ $leave->alasan ?? '-' }}</td>
                                <td>
                                    <span class="badge
                                        {{ $leave->status == 'pending' ? 'bg-warning text-dark' : '' }}
                                        {{ $leave->status == 'approved' ? 'bg-success' : '' }}
                                        {{ $leave->status == 'rejected' ? 'bg-danger' : '' }}">
                                        {{ ucfirst($leave->status) }}
                                    </span>
                                </td>
                                <td class="text-start">{{ $leave->catatan_penolakan ?? '-' }}</td>

                                @if(auth()->user()->isHsd() && $leave->status == 'pending')
                                    <td>
                                        <form action="{{ route('leaves.updateStatus', $leave) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $leave->id }}">
                                            Reject
                                        </button>
                                    </td>
                                @elseif(auth()->user()->isHsd())
                                    <td class="text-muted">-</td>
                                @endif
                            </tr>

                            {{-- Modal Reject --}}
                            <div class="modal fade" id="rejectModal{{ $leave->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('leaves.updateStatus', $leave) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Alasan Penolakan Cuti</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="status" value="rejected">
                                                <div class="mb-3">
                                                    <label class="form-label">Catatan Penolakan</label>
                                                    <textarea name="catatan_penolakan" class="form-control" rows="4" required
                                                        placeholder="Masukkan alasan penolakan cuti..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Tolak Cuti</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->isHsd() ? 9 : 8 }}" class="text-center py-4 text-muted fst-italic">
                                    Belum ada data pengajuan cuti.
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