@extends('layouts.app-layout')

@section('title', 'Pengurusan Risiko Sektor')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Pengurusan Risiko Sektor</h2>
        <p>Senarai semua risiko dalam sektor anda</p>
    </div>
    <div>
        <a href="{{ route('sektor.pengurusan_risiko.laporan_penilaian') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-chart-bar"></i> Laporan
        </a>
    </div>
</div>

<!-- Filters -->
<div class="card-box mb-4">
    <form method="GET" action="{{ route('sektor.pengurusan_risiko.index') }}" class="row g-3">
        <div class="col-md-4">
            <input type="text" class="form-control" name="search" placeholder="Cari risiko..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select class="form-select" name="tahap" onchange="this.form.submit()">
                <option value="">Semua Tahap</option>
                <option value="Tinggi" {{ request('tahap') == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                <option value="Sederhana" {{ request('tahap') == 'Sederhana' ? 'selected' : '' }}>Sederhana</option>
                <option value="Rendah" {{ request('tahap') == 'Rendah' ? 'selected' : '' }}>Rendah</option>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-orange w-100">Cari</button>
        </div>
    </form>
</div>

<!-- Risks Table -->
<div class="card-box">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>No.</th>
                    <th>Agensi</th>
                    <th>Nama Risiko</th>
                    <th>Pemilik</th>
                    <th>Tahap</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($risks as $index => $risk)
                <tr>
                    <td>{{ ($risks->currentPage() - 1) * $risks->perPage() + $index + 1 }}</td>
                    <td>{{ $risk->agensi?->nama_agensi ?? '-' }}</td>
                    <td>{{ $risk->nama_risiko }}</td>
                    <td>{{ $risk->pemilik_risiko }}</td>
                    <td>
                        @if($risk->tahap_risiko === 'Tinggi')
                            <span class="badge bg-danger">Tinggi</span>
                        @elseif($risk->tahap_risiko === 'Sederhana')
                            <span class="badge bg-warning">Sederhana</span>
                        @else
                            <span class="badge bg-info">Rendah</span>
                        @endif
                    </td>
                    <td>{{ $risk->kategoriRisiko?->nama_kategori ?? '-' }}</td>
                    <td>
                        @if($risk->status_persetujuan === 'diluluskan')
                            <span class="badge bg-success">Diluluskan</span>
                        @elseif($risk->status_persetujuan === 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @else
                            <span class="badge bg-secondary">Menunggu</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('sektor.pengurusan_risiko.show', $risk->id) }}" class="btn btn-sm btn-info" title="Lihat">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Tiada risiko ditemui</td>
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

@endsection
