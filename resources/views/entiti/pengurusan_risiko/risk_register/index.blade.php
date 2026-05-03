@extends('layouts.app-layout')

@section('title', 'Senarai Daftar Risiko')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Pengurusan Risiko</h2>
        <p>Senarai Daftar Risiko Entiti</p>
    </div>
    <div>
        <a href="{{ route('entiti.pengurusan_inventori.index') }}" class="btn btn-orange">+ Daftar Risiko</a>
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
    <h5>Senarai Daftar Risiko</h5>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Aset</th>
                    <th>Nama Risiko</th>
                    <th>Kategori Risiko</th>
                    <th>Pemilik Risiko</th>
                    <th>Skor</th>
                    <th>Tahap Risiko</th>
                    <th>Tarikh Daftar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($risks as $index => $risk)
                    @php
                        $tahap = $risk->tahapRisiko?->tahap_risiko ?? $risk->tahap_risiko;
                        $badgeClass = match ($tahap) {
                            'Sangat Tinggi', 'Tinggi' => 'bg-danger',
                            'Sederhana' => 'bg-warning',
                            'Rendah', 'Sangat Rendah' => 'bg-success',
                            default => 'bg-secondary',
                        };
                    @endphp
                    <tr class="clickable-row" data-href="{{ route('entiti.pengurusan_risiko.risk_register.show', $risk->id) }}" style="cursor: pointer;">
                        <td>{{ ($risks->currentPage() - 1) * $risks->perPage() + $index + 1 }}</td>
                        <td>{{ $risk->cbom?->sbom?->inventori?->nama_aset ?? '-' }}</td>
                        <td>{{ $risk->risiko?->nama_risiko ?? '-' }}</td>
                        <td>{{ $risk->risiko?->subKategoriRisiko?->kategoriRisiko?->kategori_risiko ?? '-' }}</td>
                        <td>{{ $risk->pemilik_risiko ?? '-' }}</td>
                        <td>{{ $risk->skor_risiko ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $badgeClass }}">{{ $tahap ?? '-' }}</span>
                        </td>
                        <td>{{ $risk->created_at?->format('d/m/Y') ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Tiada data dijumpai</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($risks->hasPages())
        <div class="mt-3">
            {{ $risks->links() }}
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.clickable-row').forEach(row => {
            row.addEventListener('click', function() {
                window.location.href = this.dataset.href;
            });
        });
    });
</script>

@endsection
