<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Leave::with('karyawan', 'approver')->latest();
    
        // Kalau karyawan, filter berdasarkan email
        if (Auth::user()->isKaryawan()) {
            $karyawan = Karyawan::where('email', Auth::user()->email)->first();
            if ($karyawan) {
                $query->where('karyawan_id', $karyawan->id);
            } else {
                $leaves = collect([]);
                return view('leaves.index', compact('leaves'));
            }
        }
    
        $leaves = $query->get();
    
        return view('leaves.index', compact('leaves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Pastikan hanya karyawan yang bisa mengajukan cuti
        if (!Auth::user()->isKaryawan()) {
            abort(403, 'Hanya karyawan yang dapat mengajukan cuti.');
        }

        $karyawan = Auth::user()->karyawan; // Data karyawan yang login

        return view('leaves.create', compact('karyawan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isKaryawan()) {
            abort(403);
        }
    
        $request->validate([
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'jenis_cuti'   => 'required|in:tahunan,sakit,bersalin,penting,lainnya',
            'alasan'       => 'nullable|string|max:500',
        ]);
    
        $karyawan = Karyawan::where('email', Auth::user()->email)->first();
    
        if (!$karyawan) {
            return redirect()->back()->with('error', 'Data karyawan Anda tidak ditemukan.');
        }
    
        Leave::create([
            'karyawan_id' => $karyawan->id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'jenis_cuti'  => $request->jenis_cuti,
            'alasan'      => $request->alasan,
            'status'      => 'pending',
        ]);
    
        // Redirect kembali ke form create + kirim notif sukses
        return redirect()->route('leaves.create')
                         ->with('success', 'Pengajuan cuti berhasil dikirim! Menunggu persetujuan dari HSD.');
    }

    /**
     * Display the specified resource (opsional, kalau perlu detail cuti).
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
     * Remove the specified resource from storage (opsional, kalau ingin ada hapus cuti).
     */
    public function destroy(Leave $leave)
    {
        // Hanya HSD atau admin yang bisa hapus (misalnya cuti salah input)
        if (!in_array(Auth::user()->role, ['hsd', 'admin'])) {
            abort(403);
        }

        $leave->delete();

        return redirect()->route('leaves.index')
                         ->with('success', 'Pengajuan cuti berhasil dihapus.');
    }
}