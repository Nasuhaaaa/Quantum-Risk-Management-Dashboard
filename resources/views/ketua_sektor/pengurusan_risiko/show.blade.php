@extends('layouts.app-layout')

@section('title', 'Lihat Risiko')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Lihat Butiran Risiko</h2>
        <p>{{ $risk->nama_risiko }}</p>
    </div>
</div>

<a href="{{ route('sektor.pengurusan_risiko.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Risk Details Card -->
<div class="card-box mb-4">
    <h5>Maklumat Risiko</h5>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Nama Risiko</label>
            <p class="mb-0">{{ $risk->nama_risiko }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Agensi/Entiti</label>
            <p class="mb-0">{{ $risk->agensi?->nama_agensi ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Pemilik Risiko</label>
            <p class="mb-0">{{ $risk->pemilik_risiko }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Kategori Risiko</label>
            <p class="mb-0">{{ $risk->kategoriRisiko?->nama_kategori ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Sub-Kategori</label>
            <p class="mb-0">{{ $risk->subKategoriRisiko?->nama_sub_kategori ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Tahap Risiko</label>
            <p class="mb-0">
                <span class="badge bg-danger">{{ $risk->tahap_risiko }}</span>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Kemungkinan</label>
            <p class="mb-0">{{ $risk->kemungkinan ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Kesan</label>
            <p class="mb-0">{{ $risk->kesan ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="form-label text-muted">Penerangan</label>
            <p class="mb-0">{{ $risk->penerangan ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Tarikh Daftar</label>
            <p class="mb-0">{{ $risk->created_at?->format('d/m/Y H:i') }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Status Persetujuan</label>
            <p class="mb-0">
                @if($risk->status_persetujuan === 'diluluskan')
                    <span class="badge bg-success">Diluluskan</span>
                @elseif($risk->status_persetujuan === 'ditolak')
                    <span class="badge bg-danger">Ditolak</span>
                @elseif($risk->status_persetujuan === 'tertunda')
                    <span class="badge bg-warning">Tertunda</span>
                @else
                    <span class="badge bg-secondary">Menunggu</span>
                @endif
            </p>
        </div>
    </div>
</div>

<!-- Root Causes Card -->
@if($risk->puncaRisiko && $risk->puncaRisiko->count() > 0)
<div class="card-box mb-4">
    <h5>Punca-Punca Risiko</h5>

    <table class="table table-sm table-hover">
        <thead class="table-light">
            <tr>
                <th>Nama Punca</th>
                <th>Kategori Punca</th>
                <th>Rancangan Mitigasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($risk->puncaRisiko as $punca)
            <tr>
                <td>{{ $punca->nama_punca }}</td>
                <td>{{ $punca->kategoriPuncaRisiko?->nama_kategori ?? '-' }}</td>
                <td>{{ $punca->pelan_mitigasi ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center text-muted">Tiada punca risiko</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endif

<!-- Actions Card -->
<div class="card-box">
    <h5>Tindakan</h5>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('sektor.pengurusan_risiko.laporan_penilaian') }}" class="btn btn-secondary">Lihat Laporan</a>
        <a href="{{ route('sektor.pengurusan_risiko.index') }}" class="btn btn-grey">Tutup</a>
    </div>
</div>

@endsection
