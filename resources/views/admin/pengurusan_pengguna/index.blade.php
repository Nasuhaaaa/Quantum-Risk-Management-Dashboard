@extends('layouts.app-layout')

@section('title', 'Senarai Pengguna')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Pengurusan Pengguna</h2>
        <p>Senarai Pengguna Sistem</p>
    </div>
    <div>
        <a href="{{ route('admin.pengurusan_pengguna.create') }}" class="btn btn-orange">+ Daftar Pengguna Baru</a>
    </div>
</div>

<!-- Alerts -->
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berjaya!</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Table Card -->
<div class="card-box">
    <h5>Senarai Pengguna</h5>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jenis Pengguna</th>
                    <th>Agensi</th>
                    <th>Tarikh Dibuat</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name ?? '-' }}</td>
                        <td>{{ $user->email ?? '-' }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $user->role_type ?? '-' }}</span>
                        </td>
                        <td>{{ $user->agensi?->nama_agensi ?? '-' }}</td>
                        <td>{{ $user->created_at?->format('d/m/Y') ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.pengurusan_pengguna.show', $user->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                            <a href="{{ route('admin.pengurusan_pengguna.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('admin.pengurusan_pengguna.destroy', $user->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Adakah anda pasti?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tiada data dijumpai</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
