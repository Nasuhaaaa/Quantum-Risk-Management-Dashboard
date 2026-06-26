@extends('layouts.app-layout')

@section('title', 'Lihat Risiko')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Lihat Butiran Risiko</h2>
        <p>{{ $risk->risiko?->nama_risiko ?? 'Maklumat Risiko' }}</p>
    </div>
</div>

<a href="{{ route('pengurusan.pengurusan_risiko.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Risk Details Card -->
<div class="card-box mb-4">
    <h5>Maklumat Risiko</h5>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Nama Risiko</label>
            <p class="mb-0">{{ $risk->risiko?->nama_risiko ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Pemilik Risiko</label>
            <p class="mb-0">{{ $risk->pemilik_risiko }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Kategori Risiko</label>
            <p class="mb-0">{{ $risk->risiko?->subKategoriRisiko?->kategoriRisiko?->kategori_risiko ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Sub-Kategori</label>
            <p class="mb-0">{{ $risk->risiko?->subKategoriRisiko?->sub_kategori_risiko ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Tahap Risiko</label>
            <p class="mb-0">
                <span class="badge bg-danger">{{ $risk->tahapRisiko?->tahap_risiko ?? $risk->tahap_risiko ?? '-' }}</span>
            </p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Kemungkinan</label>
            <p class="mb-0">{{ $risk->kemungkinan ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Kesan</label>
            <p class="mb-0">{{ $risk->kesan ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Tarikh Daftar</label>
            <p class="mb-0">{{ $risk->created_at?->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="form-label text-muted">Penerangan</label>
            <p class="mb-0">{{ $risk->penerangan ?? '-' }}</p>
        </div>
    </div>
</div>

<!-- Root Causes Card -->
<div class="card-box mb-4">
    <h5>Punca Risiko</h5>

    <table class="table table-sm table-hover">
        <thead class="table-light">
            <tr>
                <th>Nama Punca</th>
                <th>Kategori Punca</th>
                <th>Rancangan Mitigasi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $risk->puncaRisiko?->punca_risiko ?? '-' }}</td>
                <td>{{ $risk->puncaRisiko?->kategoriPuncaRisiko?->kategori_punca_risiko ?? '-' }}</td>
                <td>{{ $risk->puncaRisiko?->pelan_mitigasi ?? $risk->pelan_mitigasi ?? '-' }}</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Status & Action Card -->
@if($hasApprovalColumns)
<div class="card-box">
    <h5>Status & Tindakan</h5>

    <div class="mb-3">
        <label class="form-label text-muted">Status Semasa</label>
        <p class="mb-0">
            @if($risk->status_persetujuan === 'diluluskan')
                <span class="badge bg-success">Diluluskan</span>
            @elseif($risk->status_persetujuan === 'ditolak')
                <span class="badge bg-danger">Ditolak</span>
            @elseif($risk->status_persetujuan === 'tertunda')
                <span class="badge bg-warning">Tertunda</span>
            @else
                <span class="badge bg-secondary">Menunggu Persetujuan</span>
            @endif
        </p>
    </div>

    @if($risk->ulasan)
    <div class="mb-3">
        <label class="form-label text-muted">Ulasan</label>
        <p class="mb-0">{{ $risk->ulasan }}</p>
    </div>
    @endif

    <div class="d-flex justify-content-end gap-2 mt-4">
        @if(!$risk->status_persetujuan || $risk->status_persetujuan === 'tertunda')
        <a href="{{ route('pengurusan.pengurusan_risiko.approval_form', $risk->id) }}" class="btn btn-orange">Setuju/Tolak</a>
        @endif
        <a href="{{ route('pengurusan.pengurusan_risiko.index') }}" class="btn btn-grey">Tutup</a>
    </div>
</div>
@endif

@endsection
