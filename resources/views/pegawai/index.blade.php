@extends('layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center mb-4">Data Users</h2>
                <a href="" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#modalCreate">Create</a>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <table id="dataTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Posisi</th>
                            <th>Gaji</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($karyawan as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->posisi }}</td>
                                <td>{{ $user->gaji }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editUserModal-{{ $user->id }}">Edit</button>
                                    <form action="{{ route('karyawan.destroy', $user->id) }}" method="POST"
                                        style="display:inline-block;" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit User Modal -->
                            <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="editkaryawanModalLabel-{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editUserModalLabel-{{ $user->id }}">Edit User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('karyawan.update', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input type="text" class="form-control" name="username"
                                                        value="{{ old('username', $user->username) }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama">Posisi</label>
                                                    <input type="text" class="form-control" name="posisi"
                                                        value="{{ old('posisi', $user->posisi) }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="gaji">Gaji</label>
                                                    <input type="number" class="form-control" name="gaji" required>{{ old('gaji', $user->gaji) }}</input>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status">Role</label>
                                                    <select class="form-control" name="status" required>
                                                        <option value="1" {{ $user->role ? 'selected' : '' }}>Admin</option>
                                                        <option value="0" {{ !$user->role ? 'selected' : '' }}>Karyawan</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-3">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('karyawan.create') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="posisi">Posisi</label>
                            <input type="text" class="form-control" name="posisi" required>
                        </div>
                        <div class="form-group">
                            <label for="gaji">Gaji</label>
                            <input type="number" class="form-control" name="gaji" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="*******" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Role</label>
                            <select class="form-control" name="status" required>
                                <option value="1">Admin</option>
                                <option value="0">Karyawan</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Create User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('sweetalert::alert')

    <!-- SweetAlert Confirmation for Delete -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah anda benar?',
                    text: "ingin menghapus data ini secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit(); // Submits the form if confirmed
                    }
                });
            });
        });
    </script>

    @section('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                responsive: true
            });
        });
    </script>
    @endsection
@endsection
