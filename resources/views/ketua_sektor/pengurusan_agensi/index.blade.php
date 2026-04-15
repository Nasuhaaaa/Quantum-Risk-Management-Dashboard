@extends('layouts.app-layout')

@section('title', 'Senarai Entiti')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Pengurusan Agensi</h2>
        <p>Senarai Entiti dalam Sektor Anda</p>
    </div>
    <div>
        <a href="{{ route('sektor.pengurusan_agensi.create') }}" class="btn btn-orange">+ Entiti Baru</a>
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
    <h5>Senarai Agensi</h5>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Agensi</th>
                    <th>Pegawai Utama</th>
                    <th>Telefon</th>
                    <th>Email</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agensi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_agensi ?? '-' }}</td>
                        <td>{{ $item->nama_pic ?? '-' }}</td>
                        <td>{{ $item->no_tel_pic ?? '-' }}</td>
                        <td>{{ $item->emel_pic ?? '-' }}</td>
                        <td>
                            <a href="{{ route('sektor.pengurusan_agensi.show', $item->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                            <a href="{{ route('sektor.pengurusan_agensi.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('sektor.pengurusan_agensi.destroy', $item->id) }}" style="display:inline;">
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
