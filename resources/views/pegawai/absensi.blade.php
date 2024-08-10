@extends('layouts.master')

@section('content')
    <h1>Absensi Karyawan</h1>
    <form action="{{ route('storeAttendance') }}" method="POST">
        @csrf
        <div>
            <label for="pegawai_id">Nama Karyawan</label>
            <select name="pegawai_id" id="pegawai_id" required>
                @foreach($karyawan as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->username }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="type">Jenis Absensi</label>
            <select name="type" id="type" required>
                <option value="in">Masuk</option>
                <option value="out">Pulang</option>
            </select>
        </div>
        <button type="submit">Simpan Absensi</button>
    </form>
    @include('sweetalert::alert')
@endsection
