@extends('layouts.app-layout')

@section('title', 'Senarai Inventori')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Pengurusan Inventori</h2>
        <p>Senarai Inventori Aset</p>
    </div>
    <div>
        <a href="{{ route('entiti.pengurusan_inventori.create') }}" class="btn btn-orange">+ Daftar Inventori Baru</a>
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
    <h5>Senarai Inventori</h5>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Aset</th>
                    <th>Jenis Aset</th>
                    <th>Lokasi</th>
                    <th>Tarikh Ditambah</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventori as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_aset ?? '-' }}</td>
                        <td>{{ $item->jenis_aset ?? '-' }}</td>
                        <td>{{ $item->lokasi ?? '-' }}</td>
                        <td>{{ $item->created_at?->format('d/m/Y') ?? '-' }}</td>
                        <td>
                            <a href="{{ route('entiti.pengurusan_inventori.show', $item->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                            <a href="{{ route('entiti.pengurusan_inventori.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('entiti.pengurusan_inventori.destroy', $item->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Adakah anda pasti?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tiada data dijumpai</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
