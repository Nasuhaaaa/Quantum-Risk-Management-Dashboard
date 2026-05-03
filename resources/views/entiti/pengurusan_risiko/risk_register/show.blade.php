@extends('layouts.app-layout')

@section('title', 'Butiran Daftar Risiko')

@section('content')

@php
    $tahap = $risk->tahapRisiko?->tahap_risiko ?? $risk->tahap_risiko;
    $impak = $risk->getRelation('impak');
    $kebarangkalian = $risk->getRelation('kebarangkalian');
    $badgeClass = match ($tahap) {
        'Sangat Tinggi', 'Tinggi' => 'bg-danger',
        'Sederhana' => 'bg-warning',
        'Rendah', 'Sangat Rendah' => 'bg-success',
        default => 'bg-secondary',
    };
@endphp

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Butiran Daftar Risiko</h2>
        <p>{{ $risk->risiko?->nama_risiko ?? 'Maklumat Risiko' }}</p>
    </div>
</div>

<a href="{{ route('entiti.pengurusan_risiko.risk_register.index') }}" class="btn btn-sm btn-secondary mb-3">&larr; Kembali</a>

<!-- Asset Details -->
<div class="card-box mb-4">
    <h5>Maklumat Aset dan CBOM</h5>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Nama Aset</label>
            <p class="mb-0">{{ $risk->cbom?->sbom?->inventori?->nama_aset ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Jenis Aset</label>
            <p class="mb-0">{{ $risk->cbom?->sbom?->inventori?->jenis_aset ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Algoritma Kriptografi</label>
            <p class="mb-0">{{ $risk->cbom?->algoritma_kriptografi ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Panjang Kunci</label>
            <p class="mb-0">{{ $risk->cbom?->panjang_kunci ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Tujuan Penggunaan</label>
            <p class="mb-0">{{ $risk->cbom?->tujuan_penggunaan ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Sokongan Crypto Agility</label>
            <p class="mb-0">{{ $risk->cbom?->sokongan_crypto_agility ?? '-' }}</p>
        </div>
    </div>
</div>

<!-- Risk Details -->
<div class="card-box mb-4">
    <h5>Maklumat Risiko</h5>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Nama Risiko</label>
            <p class="mb-0">{{ $risk->risiko?->nama_risiko ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Pemilik Risiko</label>
            <p class="mb-0">{{ $risk->pemilik_risiko ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Kategori Risiko</label>
            <p class="mb-0">{{ $risk->risiko?->subKategoriRisiko?->kategoriRisiko?->kategori_risiko ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Subkategori Risiko</label>
            <p class="mb-0">{{ $risk->risiko?->subKategoriRisiko?->sub_kategori_risiko ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Punca Risiko</label>
            <p class="mb-0">{{ $risk->puncaRisiko?->punca_risiko ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Kategori Punca Risiko</label>
            <p class="mb-0">{{ $risk->puncaRisiko?->kategoriPuncaRisiko?->kategori_punca_risiko ?? '-' }}</p>
        </div>
    </div>
</div>

<!-- Assessment Details -->
<div class="card-box mb-4">
    <h5>Penilaian Risiko</h5>

    <div class="row">
        <div class="col-md-3 mb-3">
            <label class="form-label text-muted">Impak</label>
            <p class="mb-0">{{ $impak?->tahap ?? $risk->impak ?? '-' }}</p>
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label text-muted">Kemungkinan</label>
            <p class="mb-0">{{ $kebarangkalian?->tahap ?? $risk->kemungkinan ?? '-' }}</p>
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label text-muted">Skor Risiko</label>
            <p class="mb-0">{{ $risk->skor_risiko ?? '-' }}</p>
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label text-muted">Tahap Risiko</label>
            <p class="mb-0"><span class="badge {{ $badgeClass }}">{{ $tahap ?? '-' }}</span></p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Kawalan Sedia Ada</label>
            <p class="mb-0">{{ $risk->kawalan_sedia_ada ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Pelan Mitigasi</label>
            <p class="mb-0">{{ $risk->pelan_mitigasi ?? $risk->puncaRisiko?->pelan_mitigasi ?? '-' }}</p>
        </div>
    </div>
</div>

<!-- Status -->
<div class="card-box">
    <h5>Status</h5>

    <div class="row">
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
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Tarikh Daftar</label>
            <p class="mb-0">{{ $risk->created_at?->format('d/m/Y H:i') ?? '-' }}</p>
        </div>
    </div>

    @if($risk->ulasan)
        <div class="mb-3">
            <label class="form-label text-muted">Ulasan</label>
            <p class="mb-0">{{ $risk->ulasan }}</p>
        </div>
    @endif

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('entiti.pengurusan_risiko.risk_register.index') }}" class="btn btn-grey">Tutup</a>
    </div>
</div>

@endsection
