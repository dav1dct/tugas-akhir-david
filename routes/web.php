<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KaryawanBaruController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/pengumuman', function () {
    $path = 'pengumuman.pdf';
    if (!\Storage::disk('public')->exists($path)) {
        abort(404, 'File tidak ditemukan.');
    }
    return response()->file(storage_path('app/public/' . $path));
})->name('pengumuman.view');

// Formulir pendaftaran karyawan baru (public)
Route::get('/daftar', [KaryawanBaruController::class, 'create'])->name('karyawanbaru.create');
Route::post('/karyawanbaru', [KaryawanBaruController::class, 'store'])->name('karyawanbaru.store');
Route::get('/karyawanbaru/success', [KaryawanBaruController::class, 'success'])->name('karyawanbaru.success');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['verified'])
        ->name('dashboard');
    Route::post('/dashboard/uploadpdf', [DashboardController::class, 'uploadPDF'])->name('dashboard.upload.pdf');

    // Karyawan Baru
    Route::prefix('karyawanbaru')->group(function () {
        Route::get('/', [KaryawanBaruController::class, 'index'])->name('karyawanbaru.index');
        Route::get('/export', [KaryawanBaruController::class, 'export'])->name('karyawanbaru.export');
        Route::put('/{id}/status', [KaryawanBaruController::class, 'updateStatus'])->name('karyawanbaru.updateStatus');
        Route::get('/{id}/edit', [KaryawanBaruController::class, 'edit'])->name('karyawanbaru.edit');
        Route::get('/download/{id}/{file}', [KaryawanBaruController::class, 'download'])->name('karyawanbaru.download');
        Route::get('/image/{id}/{file}', [KaryawanBaruController::class, 'showImage'])->name('karyawanbaru.image');
    });

    // Karyawan
    Route::prefix('karyawan')->group(function () {
        Route::get('/', [KaryawanController::class, 'index'])->name('karyawan.index');
        Route::get('/export', [KaryawanController::class, 'export'])->name('karyawan.export');
        Route::get('/tambah', [KaryawanController::class, 'create'])->name('karyawan.create');
        Route::post('/', [KaryawanController::class, 'store'])->name('karyawan.store');
        Route::get('/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
        Route::put('/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update');
    });
    
    Route::resource('leaves', \App\Http\Controllers\LeaveController::class)->only([
        'index',    // daftar cuti (GET /leaves)
        'create',   // form ajukan (GET /leaves/create)
        'store',    // simpan pengajuan (POST /leaves)
        'show',     // detail cuti (GET /leaves/{id}) - opsional
    ]);

    // Route khusus approve/reject (hanya HSD)
    Route::patch('leaves/{leave}/status', [\App\Http\Controllers\LeaveController::class, 'updateStatus'])
         ->name('leaves.updateStatus')
         ->middleware('role:hsd');
    
    Route::resource('jenis-cuti', \App\Http\Controllers\JenisCutiController::class);

});

// ====================== ABSENSI ======================
    Route::middleware(['role:admin,hsd,pemimpin'])->group(function () {

    Route::resource('attendances', \App\Http\Controllers\AttendanceController::class)
        ->only(['index']);

    Route::get('attendances/import', [\App\Http\Controllers\AttendanceController::class, 'importForm'])
        ->name('attendances.importForm');

    Route::post('attendances/import', [\App\Http\Controllers\AttendanceController::class, 'import'])
        ->name('attendances.import');

});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
