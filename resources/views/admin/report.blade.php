@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>Laporan Gaji Karyawan</h2>

        <!-- Menampilkan notifikasi jika ada -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('showPayrollReport') }}" method="GET">
            @csrf
            <div class="form-group">
                <label for="month">Pilih Bulan</label>
                <input type="month" class="form-control" name="month" value="{{ $month }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
        </form>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Nama Pegawai</th>
                    <th>Gaji Pokok</th>
                    <th>Denda Keterlambatan</th>
                    <th>Denda Ketidakhadiran</th>
                    <th>Gaji Bersih</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payrolls as $payroll)
                    <tr>
                            <td>{{ $payroll['pegawai'] }}</td>
                        
                        <td>{{ number_format($payroll['gaji_pokok'], 2) }}</td>
                        <td>{{ number_format($payroll['denda_telat'], 2) }}</td>
                        <td>{{ number_format($payroll['absensi'], 2) }}</td>
                        <td>{{ number_format($payroll['gaji'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('sweetalert::alert')
@endsection
