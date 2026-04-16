@extends('layouts.app-layout')

@section('title', 'Senarai Sektor')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Pengurusan Sektor</h2>
        <p>Senarai Semua Sektor Sistem</p>
    </div>
    <div>
        <a href="{{ route('admin.pengurusan_sektor.create') }}" class="btn btn-orange">+ Sektor Baru</a>
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
    <h5>Senarai Sektor</h5>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Sektor</th>
                    <th>Ketua Sektor</th>
                    <th>Tarikh Dibuat</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sectors as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_sektor ?? '-' }}</td>
                        <td>{{ $item->ketua_sektor ?? '-' }}</td>
                        <td>{{ $item->created_at?->format('d/m/Y') ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.pengurusan_sektor.show', $item->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                            <a href="{{ route('admin.pengurusan_sektor.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('admin.pengurusan_sektor.destroy', $item->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Adakah anda pasti?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tiada data dijumpai</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
