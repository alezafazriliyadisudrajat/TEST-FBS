@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>Form Jam Kerja dan Hari Kerja</h2>

        <!-- Menampilkan notifikasi jika ada -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('storeWorkday') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="hari_dalam_seminggu">Hari dalam Seminggu</label>
                <input type="text" class="form-control" name="hari_dalam_seminggu" required>
            </div>

            <div class="form-group">
                <label for="mulai">Jam Mulai</label>
                <input type="time" class="form-control" name="mulai" required>
            </div>

            <div class="form-group">
                <label for="selesai">Jam Selesai</label>
                <input type="time" class="form-control" name="selesai" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    @include('sweetalert::alert')
@endsection
