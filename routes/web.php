<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PayyRollController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('isGuest')->group(function (){
    Route::get('/', [AdminController::class, 'Login'])->name('login');
    Route::post('/login', [AdminController::class, 'AuthLogin'])->name('authlogin');
});

Route::middleware('isLogin')->group(function (){
    Route::get('/dashboard', [Controller::class, 'Dashboard'])->name('dashboard');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::get('/karyawan', [AdminController::class, 'index'])->name('karyawan');
    Route::post('/karyawan/create', [AdminController::class, 'store'])->name('karyawan.create');
    Route::put('/karyawan/update/{id}', [AdminController::class, 'update'])->name('karyawan.update');
    Route::delete('/karyawan/delete/{id}', [AdminController::class, 'destroy'])->name('karyawan.destroy');

    // Rute untuk menampilkan form gaji pegawai
    Route::get('/salary-form', [PayyRollController::class, 'ShowSalaryForm'])->name('showSalaryForm');

    // Route untuk menyimpan atau memperbarui detail gaji pegawai
    Route::post('/store-salary', [PayyRollController::class, 'storeSalary'])->name('storeSalary');

    // Route untuk menampilkan form hari kerja
    Route::get('/workday-form', [PayyRollController::class, 'showWorkday'])->name('showWorkday');

    // Route untuk menyimpan atau memperbarui detail hari kerja
    Route::post('/store-workday', [PayyRollController::class, 'storeWorkday'])->name('storeWorkday');

    // Route untuk menampilkan laporan gaji
    Route::get('/payroll-report', [PayyRollController::class, 'showPayrollReport'])->name('showPayrollReport');

    // Rute untuk menampilkan form absensi
    Route::get('/absensi', [AbsensiController::class, 'showAttendanceForm'])->name('absensiForm');

    // Rute untuk menyimpan absensi
    Route::post('/store-attendance', [AbsensiController::class, 'storeAttendance'])->name('storeAttendance');

    // Rute untuk menampilkan laporan absensi (Admin)
    Route::get('/absensi-report', [AbsensiController::class, 'showAbsensiReport'])->name('showAbsensiReport');
});
