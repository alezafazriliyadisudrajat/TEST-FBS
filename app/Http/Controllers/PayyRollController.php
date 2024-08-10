<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absensi;
use App\Models\HariKerja;
use App\Models\GajiPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class PayyRollController extends Controller
{
    public function ShowSalaryForm()
    {
        // Get data salary employee
        $karyawan = User::all();
        return view('admin.payy_roll', compact('karyawan'));
    }

    public function storeSalary(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'gaji_pokok' => 'required|numeric',
            'denda_telat' => 'required|numeric',
        ]);
    
        GajiPegawai::updateOrCreate(
            ['user_id' => $request->user_id],
            ['gaji_pokok' => $request->gaji_pokok, 'denda_telat' => $request->denda_telat]
        );
    
        return redirect()->back()->with('success', 'Salary details saved successfully.');
    }
    

    // Logika jam kerja dan hari kerja
    public function showWorkday()
    {
        return view('admin.hari_kerja');
    }

    public function storeWorkday(Request $request)
    {
        $validated = $request->validate([
            'hari_dalam_seminggu' => 'required|string',
            'mulai' => 'required|date_format:H:i',
            'selesai' => 'required|date_format:H:i',
        ]);

        HariKerja::updateOrCreate(
            ['id' => 1], // Dengan asumsi hanya satu catatan demi kesederhanaan
            [
                'hari_dalam_seminggu' => $request->hari_dalam_seminggu,
                'mulai' => $request->mulai,
                'selesai' => $request->selesai,
            ],
        );

        return redirect()->back()->with('success', 'Workday details saved successfully.');
    }

    // Logika untuk laporan 
    public function showPayrollReport(Request $request)
{
    // Get the month from request or default to the current month
    $month = $request->input('month', Carbon::now()->format('Y-m'));

    // Retrieve all employees
    $karyawan = User::all();
    $payrolls = [];

    // Get workday details
    $workday = HariKerja::first(); // Assuming only one record for simplicity

    if ($workday) {
        try {
            $workdayStart = Carbon::createFromFormat('H:i', $workday->mulai);
            $workdayEnd = Carbon::createFromFormat('H:i', $workday->selesai);
        } catch (\Exception $e) {
            // Handle date parsing errors
            $workdayStart = Carbon::createFromFormat('H:i', '09:00');
            $workdayEnd = Carbon::createFromFormat('H:i', '17:00');
            Log::error('Workday format error: ' . $e->getMessage());
        }
    } else {
        // Default values if no workday record exists
        $workdayStart = Carbon::createFromFormat('H:i', '09:00');
        $workdayEnd = Carbon::createFromFormat('H:i', '17:00');
    }

    foreach ($karyawan as $employee) {
        $gaji = GajiPegawai::where('user_id', $employee->id)->first();
        $absensi = Absensi::where('user_id', $employee->id)
            ->whereBetween('tanggal', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()])
            ->get();

        $daysInMonth = Carbon::parse($month)->daysInMonth;
        $gajipokok = $gaji ? $gaji->gaji_pokok : 0;
        $dendatelat = $gaji ? $gaji->denda_telat : 0;

        // Calculate late fines and absences
        $totaltelat = $absensi->filter(function ($item) use ($workdayStart) {
            return Carbon::createFromFormat('H:i:s', $item->check_in)->gt($workdayStart);
        })->count();

        $totalAbsence = $absensi->filter(function ($item) {
            return is_null($item->check_out);
        })->count();

        $fineForLate = $totaltelat * $dendatelat;
        $fineForAbsence = $totalAbsence * ($gajipokok / $daysInMonth);

        $netSalary = $gajipokok - $fineForLate - $fineForAbsence;

        $payrolls[] = [
            'pegawai' => $employee->username,
            'gaji_pokok' => $gajipokok,
            'denda_telat' => $fineForLate,
            'absensi' => $fineForAbsence,
            'gaji' => $netSalary
        ];
    }

    return view('admin.report', compact('payrolls', 'month'));
}

    
}
