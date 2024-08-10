@extends('layouts.master')
@section('content')
    @if (Auth::user()->role == 'admin')
        <h1>Dashboad Admin</h1>
    @else
        <h1>Dashboad User</h1>
    @endif
@endsection
