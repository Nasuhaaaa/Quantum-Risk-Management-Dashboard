@extends('layouts.app-layout')

@section('title', 'Senarai Daftar Risiko')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Pengurusan Risiko</h2>
        <p>Senarai Daftar Risiko Entiti Anda</p>
    </div>
    <div>
        <a href="{{ route('entiti.pengurusan_risiko.create') }}" class="btn btn-orange">+ Daftar Risiko Baru</a>
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
    <h5>Senarai Risiko Didaftarkan</h5>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Risiko</th>
                    <th>Pemilik Risiko</th>
                    <th>Tahap Risiko</th>
                    <th>Tarikh</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($risks as $risk)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $risk->nama_risiko ?? '-' }}</td>
                        <td>{{ $risk->pemilik_risiko ?? '-' }}</td>
                        <td>
                            <span class="badge bg-danger">{{ $risk->tahap_risiko ?? '-' }}</span>
                        </td>
                        <td>{{ $risk->created_at?->format('d/m/Y') ?? '-' }}</td>
                        <td>
                            <a href="{{ route('entiti.pengurusan_risiko.show', $risk->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                            <a href="{{ route('entiti.pengurusan_risiko.edit', $risk->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('entiti.pengurusan_risiko.destroy', $risk->id) }}" style="display:inline;">
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
