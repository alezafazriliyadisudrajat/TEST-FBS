<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AbsensiController extends Controller
{
    // Menyimpan data absensi
    public function storeAttendance(Request $request)
    {
        $validated = $request->validate([
            'pegawai_id' => 'required|exists:users,id',
            'type' => 'required|in:in,out',
        ]);

        $attendance = new Absensi();
        $attendance->user_id = $request->pegawai_id; // Ubah dari user_id menjadi pegawai_id
        $attendance->tanggal = Carbon::now()->format('Y-m-d');
        
        if ($request->type === 'in') {
            $attendance->check_in = Carbon::now();
            $attendance->check_out = Carbon::now();
        } else {
            $attendance->check_in = Carbon::now();
            $attendance->check_out = Carbon::now();
        }

        $attendance->save();

        return redirect()->back()->with('success', 'Attendance recorded successfully.');
    }

    // Menampilkan form absensi dengan daftar karyawan
    public function showAttendanceForm()
    {
        $karyawan = User::all(); // Mengambil semua data karyawan
        return view('pegawai.absensi', compact('karyawan'));
    }

    // Menampilkan laporan absensi
    public function showAbsensiReport(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('Y-m'));

        $absensi = Absensi::whereBetween('tanggal', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()])
            ->get();

        return view('admin.absensi_report', compact('absensi', 'month'));
    }
}
