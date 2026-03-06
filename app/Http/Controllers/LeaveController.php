<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\JenisCuti;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource (semua role bisa lihat).
     */
    public function index()
    {
        $query = Leave::with(['karyawan', 'approver', 'jenisCuti'])->latest('start_date');
    
        // Filter khusus untuk karyawan biasa: hanya cuti miliknya sendiri
        if (Auth::user()->isKaryawan()) {
            $karyawan = Karyawan::where('email', Auth::user()->email)->first();
            if ($karyawan) {
                $query->where('karyawan_id', $karyawan->id);
            } else {
                $leaves = collect([]);
                return view('leaves.index', compact('leaves'))
                    ->with('error', 'Data karyawan Anda tidak ditemukan. Hubungi HSD.');
            }
        }
        // Admin, HSD, Pimpinan lihat SEMUA cuti (tidak ada filter karyawan)
    
        // Tambah filter dari GET query (untuk semua role)
        if (request('jenis_cuti_id')) {
            $query->where('jenis_cuti_id', request('jenis_cuti_id'));
        }
    
        if (request('status')) {
            $query->where('status', request('status'));
        }
    
        if (request('start_date')) {
            $query->whereDate('start_date', '>=', request('start_date'));
        }
    
        if (request('end_date')) {
            $query->whereDate('end_date', '<=', request('end_date'));
        }
    
        $leaves = $query->get()->fresh();
    
        // Kirim semua jenis cuti untuk dropdown filter
        $jenisCutis = JenisCuti::orderBy('kode')->get();
    
        return view('leaves.index', compact('leaves', 'jenisCutis'));
    }

    /**
     * Show the form for creating a new resource (hanya karyawan).
     */
    public function create()
    {
        // Pastikan hanya karyawan yang bisa mengajukan cuti
        if (!Auth::user()->isKaryawan()) {
            abort(403, 'Hanya karyawan yang dapat mengajukan cuti.');
        }

        // Cari data karyawan untuk info tambahan di form (opsional)
        $karyawan = Karyawan::where('email', Auth::user()->email)->first();

        return view('leaves.create', compact('karyawan'));
    }

    /**
     * Store a newly created resource in storage (hanya karyawan).
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isKaryawan()) {
            abort(403);
        }
    
        $request->validate([
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'jenis_cuti_id'  => 'required|exists:jenis_cutis,id',
            'alasan'         => 'nullable|string|max:500',
        ]);
    
        $jenisCuti = JenisCuti::find($request->jenis_cuti_id);
    
        // Validasi durasi maksimal kalau ada
        if ($jenisCuti && $jenisCuti->durasi_maks) {
            $durasi = \Carbon\Carbon::parse($request->start_date)->diffInDays(\Carbon\Carbon::parse($request->end_date)) + 1;
            if ($durasi > $jenisCuti->durasi_maks) {
                return redirect()->back()
                                 ->withInput()
                                 ->withErrors(['end_date' => "Durasi cuti melebihi batas maksimal {$jenisCuti->durasi_maks} hari untuk jenis ini."]);
            }
        }
    
        $karyawan = Karyawan::where('email', Auth::user()->email)->first();
    
        if (!$karyawan) {
            return redirect()->back()->with('error', 'Data karyawan Anda tidak ditemukan. Hubungi HSD.');
        }
    
        // Tentukan status otomatis berdasarkan butuh_persetujuan
        $status = $jenisCuti && !$jenisCuti->butuh_persetujuan ? 'approved' : 'pending';
    
        Leave::create([
            'karyawan_id'    => $karyawan->id,
            'jenis_cuti_id'  => $request->jenis_cuti_id,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'alasan'         => $request->alasan,
            'status'         => $status,
            'approved_by'    => $status === 'approved' ? Auth::id() : null,
            'approved_at'    => $status === 'approved' ? now() : null,
        ]);
    
        // Pesan khusus kalau otomatis approved
        $pesan = $status === 'approved'
            ? 'Pengajuan cuti berhasil dan langsung disetujui (jenis cuti ini tidak memerlukan persetujuan).'
            : 'Pengajuan cuti berhasil dikirim! Menunggu persetujuan dari HSD.';
    
            return redirect()->route('leaves.index', ['_t' => now()->timestamp])
            ->with('success', $pesan);
    }

    /**
     * Display the specified resource (opsional, detail cuti).
     */
    public function show(Leave $leave)
    {
        // Semua role yang login bisa lihat detail cuti
        return view('leaves.show', compact('leave'));
    }

    /**
     * Update status cuti (approve/reject) - HANYA HSD
     */
    public function updateStatus(Request $request, Leave $leave)
    {
        if (!Auth::user()->isHsd()) {
            abort(403, 'Hanya HSD yang berhak mengubah status cuti.');
        }

        $request->validate([
            'status'            => 'required|in:approved,rejected',
            'catatan_penolakan' => 'nullable|string|max:500|required_if:status,rejected',
        ]);

        $leave->update([
            'status'            => $request->status,
            'approved_by'       => Auth::id(),
            'approved_at'       => now(),
            'catatan_penolakan' => $request->catatan_penolakan,
        ]);

        return redirect()->back()->with('success', 'Status cuti berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage (opsional, hanya HSD/admin).
     */
    public function destroy(Leave $leave)
    {
        if (!in_array(Auth::user()->role, ['hsd', 'admin'])) {
            abort(403);
        }

        $leave->delete();

        return redirect()->route('leaves.index')
                         ->with('success', 'Pengajuan cuti berhasil dihapus.');
    }
}