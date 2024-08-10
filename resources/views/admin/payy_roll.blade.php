@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>Form Gaji Pegawai</h2>

        <!-- Menampilkan notifikasi jika ada -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('storeSalary') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="pegawai_id">Pegawai</label>
                <select class="form-control" name="pegawai_id" required>
                    <option value="">Pilih Pegawai</option>
                    @foreach($karyawan as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->username }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="gaji_pokok">Gaji Pokok</label>
                <input type="number" step="0.01" class="form-control" name="gaji_pokok" required>
            </div>

            <div class="form-group">
                <label for="denda_telat">Denda Keterlambatan</label>
                <input type="number" step="0.01" class="form-control" name="denda_telat" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    @include('sweetalert::alert')
@endsection
