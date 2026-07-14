@extends('layouts.app-layout')

@section('title', 'Rumusan Status Kelulusan Daftar Risiko')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Pengurusan Risiko</h2>
        <p>{{ $isReviewMode ? 'Semak dan sahkan daftar risiko' : 'Senarai semua daftar risiko' }}</p>
    </div>
</div>

<!-- Alerts -->
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berjaya!</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card-box">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h5 class="mb-1">{{ $isReviewMode ? 'Risiko untuk Semakan' : 'Pendaftaran Risiko Mengikut Sektor & Entiti' }}</h5>
            <div class="text-muted small">Ringkasan pendaftaran mengikut sektor dan agensi</div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <span class="badge bg-primary-subtle text-primary">Jumlah: {{ $summary['total'] }}</span>
            <span class="badge bg-success-subtle text-success">Diluluskan: {{ $summary['approved'] }}</span>
            <span class="badge bg-danger-subtle text-danger">Ditolak: {{ $summary['rejected'] }}</span>
            <span class="badge bg-warning-subtle text-warning">Dalam semakan: {{ $summary['pending'] }}</span>
        </div>
    </div>

    @if($isReviewMode && !$hasApprovalColumns)
        <div class="alert alert-warning">
            Fungsi persetujuan belum tersedia untuk struktur pangkalan data semasa. Senarai risiko dipaparkan tanpa tindakan Setuju/Tolak.
        </div>
    @endif

    @forelse($groupedRisks as $sector)
        <div class="border rounded-3 p-3 mb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold mb-1 text-primary" style="font-size: 1rem; letter-spacing: 0.02em;">{{ $sector['sector_name'] }}</h6>
                    <div class="text-muted small">{{ $sector['total'] }} risiko</div>
                </div>
                <span class="badge bg-primary-subtle text-primary" style="font-size: 0.8rem; padding: 0.45rem 0.7rem;">{{ count($sector['agencies']) }} agensi</span>
            </div>

            <div class="row g-3">
                @foreach($sector['agencies'] as $agency)
                    <div class="col-lg-6">
                        <div class="border rounded-3 p-3 h-100" style="border-left: 3px solid #4f83d8 !important; background: linear-gradient(90deg, #f8fbff 0%, #ffffff 100%);">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="fw-bold text-primary" style="font-size: 0.98rem; letter-spacing: 0.01em;">{{ $agency['agency_name'] }}</div>
                                    <div class="text-muted small">{{ $agency['total'] }} risiko terdaftar</div>
                                </div>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-success-subtle text-success">{{ $agency['approved'] }}</span>
                                    <span class="badge bg-danger-subtle text-danger">{{ $agency['rejected'] }}</span>
                                    <span class="badge bg-warning-subtle text-warning">{{ $agency['pending'] }}</span>
                                </div>
                            </div>

                            <div class="mt-3">
                                @foreach($agency['risks'] as $risk)
                                    <a href="{{ route('pengurusan.pengurusan_risiko.show', $risk->id) }}" class="d-flex justify-content-between align-items-center py-2 border-top text-decoration-none text-dark">
                                        <div>
                                            <div class="small fw-semibold">{{ $risk->risiko?->nama_risiko ?? 'Tanpa nama' }}</div>
                                            <div class="text-muted small">{{ $risk->cbom?->sbom?->inventori?->nama_aset ?? '-' }}</div>
                                        </div>
                                        @if(!empty($risk->approval_status))
                                            <span class="badge {{ $risk->approval_status === 'Diluluskan' ? 'bg-success-subtle text-success' : ($risk->approval_status === 'Ditolak' ? 'bg-danger-subtle text-danger' : 'bg-warning-subtle text-warning') }}">
                                                {{ $risk->approval_status }}
                                            </span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="text-center text-muted py-4">Tiada data dijumpai</div>
    @endforelse
</div>

<div class="mt-4">
    {{ $risks->links() }}
</div>

@endsection
