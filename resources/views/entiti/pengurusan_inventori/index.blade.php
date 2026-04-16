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
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Jenis Aset</th>
                    <th>Nama Aset</th>
                    <th>Lokasi Pemilik</th>
                    <th>Sistem Legasi</th>
                    <th>Catatan</th>
                    <th>Tarikh Ditambah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventori as $item)
                    <tr class="clickable-row" data-href="{{ route('entiti.pengurusan_inventori.show', $item->id) }}" style="cursor: pointer; background-color: #f9f9f9;" onmouseover="this.style.backgroundColor='#e9ecef';" onmouseout="this.style.backgroundColor='#f9f9f9';">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->jenis_aset ?? '-' }}</td>
                        <td>{{ $item->nama_aset ?? '-' }}</td>
                        <td>{{ $item->lokasi_pemilik ?? '-' }}</td>
                        <td>{{ $item->sistem_legasi ?? '-' }}</td>
                        <td>{{ $item->catatan ?? '-' }}</td>
                        <td>{{ $item->created_at?->format('d/m/Y') ?? '-' }}</td>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.clickable-row');
        rows.forEach(row => {
            row.addEventListener('click', function() {
                window.location.href = this.dataset.href;
            });
        });
    });
</script>

@endsection
