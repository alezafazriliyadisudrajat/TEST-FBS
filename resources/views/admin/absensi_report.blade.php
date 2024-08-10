@extends('layouts.master')

@section('content')
    <h1>Laporan Absensi</h1>
    <form action="{{ route('showAbsensiReport') }}" method="GET">
        @csrf
        <div>
            <label for="month">Pilih Bulan</label>
            <input type="month" name="month" id="month" value="{{ $month }}" required>
        </div>
        <button type="submit">Tampilkan Laporan</button>
    </form>

    <table id="absensiTable" class="display">
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absensi as $record)
                <tr>
                    <td>{{ $record->pegawai->username }}</td>
                    <td>{{ $record->tanggal }}</td>
                    <td>{{ $record->check_in }}</td>
                    <td>{{ $record->check_out }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @include('sweetalert::alert')

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#absensiTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true
            });
        });
    </script>
    @endpush
@endsection
