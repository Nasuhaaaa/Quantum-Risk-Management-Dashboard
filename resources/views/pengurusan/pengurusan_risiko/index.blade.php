@extends('layouts.app-layout')

@section('title', 'Senarai Daftar Risiko')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Pengurusan Risiko</h2>
        <p>Senarai Daftar Risiko untuk Semak dan Sahkan</p>
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
    <h5>Senarai Risiko untuk Pemeriksaan</h5>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Risiko</th>
                    <th>Entiti</th>
                    <th>Tahap Risiko</th>
                    <th>Pemilik</th>
                    <th>Tarikh Daftar</th>
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
                        <td>{{ $risk->pemilik_risiko ?? '-' }}</td>
                        <td>{{ $risk->created_at?->format('d/m/Y') ?? '-' }}</td>
                        <td>
                            <a href="{{ route('pengurusan.pengurusan_risiko.show', $risk->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                            <a href="{{ route('pengurusan.pengurusan_risiko.approval_form', $risk->id) }}" class="btn btn-sm btn-warning">Setuju/Tolak</a>
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
