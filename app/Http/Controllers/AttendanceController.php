<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Karyawan;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AttendanceImport;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::query();

        // Filter NIK
        if ($request->nik) {
            $query->where('nik', 'like', '%' . $request->nik . '%');
        }

        // Filter Nama
        if ($request->nama) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        // Filter Tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $attendances = $query->orderBy('date','desc')->get();

        return view('attendances.index', compact('attendances'));
    }

    public function importForm()
    {
        return view('attendances.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
    
        $file = $request->file('file');
    
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
    
        foreach ($rows as $index => $row) {

            if ($index == 0) continue;
        
            Attendance::updateOrCreate(
                [
                    'nik' => $row[0],
                    'date' => $row[2],
                ],
                [
                    'nama' => $row[1],
                    'check_in' => $row[3] == '-' ? null : $row[3],
                    'check_out' => $row[4] == '-' ? null : $row[4],
                ]
            );
        }
    
        return redirect()->route('attendances.index')
            ->with('success','Data absensi berhasil diimport.');
    }
}