@extends('layouts.superadmin')

@section('dashboard-content')
    <h1>Manage Admin & Finance</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->role }}</td>
                    <td>
                        <a href="#" class="icon-view"><i class="fas fa-eye"></i></a> <!-- View detail -->
                        <a href="#" class="icon-edit"><i class="fas fa-pencil-alt"></i></a> <!-- Edit -->
                        <form action="{{ url('/superadmin/dashboard/block-user/' . $admin->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-tolak icon-delete"><i class="fas fa-trash"></i> Blokir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Form create admin baru -->
    <form action="/superadmin/dashboard/create-admin" method="POST">
        @csrf
        <!-- Input name, email, password, role (admin/finance) -->
        <button type="submit" class="btn btn-simpan">Simpan</button>
    </form>
@endsection