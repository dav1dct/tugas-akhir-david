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

    {{-- Tombol Ajukan Cuti --}}
    @if(auth()->user()->isKaryawan())
        <a href="{{ route('leaves.create') }}" class="btn btn-primary mb-3">
            Ajukan Cuti Baru
        </a>
    @endif

    {{-- Jika kosong --}}
    @if($leaves->isEmpty())
        <div class="text-center py-5 bg-light rounded shadow-sm">
            <h4 class="text-muted">Daftar cuti masih kosong</h4>
        </div>

    @else

    <table class="table table-bordered border-2" style="border: 2px solid #0d6efd;">
        <thead class="align-middle text-center fw-bold fs-5">
            <tr>
                <th style="width: 60px">No</th>
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
            @foreach($leaves as $index => $leave)

            <tr>
                <td class="text-center">{{ $index + 1 }}</td>

                <td>
                    {{ $leave->karyawan->nama_lengkap ?? 'Tidak ditemukan' }}
                </td>

                <td class="text-center">
                    {{ \Carbon\Carbon::parse($leave->start_date)->format('d-m-Y') }}
                </td>

                <td class="text-center">
                    {{ \Carbon\Carbon::parse($leave->end_date)->format('d-m-Y') }}
                </td>

                <td class="text-center">
                    {{ ucfirst($leave->jenis_cuti) }}
                </td>

                <td>
                    {{ $leave->alasan ?? '-' }}
                </td>

                <td class="text-center">
                    <span class="badge
                        {{ $leave->status == 'pending' ? 'bg-warning text-dark' : '' }}
                        {{ $leave->status == 'approved' ? 'bg-success' : '' }}
                        {{ $leave->status == 'rejected' ? 'bg-danger' : '' }}">
                        {{ ucfirst($leave->status) }}
                    </span>
                </td>
                <td>{{ $leave->catatan_penolakan ?? '-' }}</td>
                {{-- AKSI HSD --}}
                @if(auth()->user()->isHsd() && $leave->status == 'pending')
                <td class="text-center">

                    {{-- APPROVE --}}
                    <form action="{{ route('leaves.updateStatus', $leave) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="status" value="approved">

                        <button type="submit" class="btn btn-sm btn-success">
                            Approve
                        </button>
                    </form>


                    {{-- REJECT BUTTON (OPEN MODAL) --}}
                    <button
                        class="btn btn-sm btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#rejectModal{{ $leave->id }}">
                        Reject
                    </button>

                </td>

                @elseif(auth()->user()->isHsd())
                <td class="text-center">-</td>
                @endif

            </tr>


            {{-- MODAL REJECT --}}
            <div class="modal fade" id="rejectModal{{ $leave->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form action="{{ route('leaves.updateStatus', $leave) }}" method="POST">

                            @csrf
                            @method('PATCH')

                            <div class="modal-header">
                                <h5 class="modal-title">
                                    Alasan Penolakan Cuti
                                </h5>

                                <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                                </button>
                            </div>


                            <div class="modal-body">

                                <input type="hidden" name="status" value="rejected">

                                <div class="mb-3">
                                    <label class="form-label">
                                        Catatan Penolakan
                                    </label>

                                    <textarea
                                        name="catatan_penolakan"
                                        class="form-control"
                                        rows="4"
                                        required
                                        placeholder="Masukkan alasan penolakan cuti...">
                                    </textarea>
                                </div>

                            </div>


                            <div class="modal-footer">

                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                    Batal
                                </button>

                                <button
                                    type="submit"
                                    class="btn btn-danger">
                                    Tolak Cuti
                                </button>

                            </div>

                        </form>

                    </div>
                </div>
            </div>

            @endforeach
        </tbody>

    </table>

    @endif

</div>
@endsection