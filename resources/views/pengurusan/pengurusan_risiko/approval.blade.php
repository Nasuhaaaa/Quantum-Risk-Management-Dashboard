@extends('layouts.app-layout')

@section('title', 'Setuju/Tolak Risiko')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Semak & Sahkan Risiko</h2>
        <p>{{ $risk->nama_risiko }}</p>
    </div>
</div>

<a href="{{ route('pengurusan.pengurusan_risiko.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Risk Details Card -->
<div class="card-box mb-4">
    <h5>Maklumat Risiko</h5>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Nama Risiko</label>
            <p class="mb-0">{{ $risk->nama_risiko }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Pemilik Risiko</label>
            <p class="mb-0">{{ $risk->pemilik_risiko }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Tahap Risiko</label>
            <p class="mb-0">
                <span class="badge bg-danger">{{ $risk->tahap_risiko }}</span>
            </p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Tarikh Daftar</label>
            <p class="mb-0">{{ $risk->created_at?->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</div>

<!-- Approval Form Card -->
<div class="card-box">
    <h5>Status Persetujuan</h5>

    <form method="POST" action="{{ route('pengurusan.pengurusan_risiko.approve', $risk->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="status_persetujuan" class="form-label">Keputusan</label>
            <select class="form-select @error('status_persetujuan') is-invalid @enderror" id="status_persetujuan" name="status_persetujuan" required>
                <option value="">Pilih Keputusan</option>
                <option value="diluluskan">Diluluskan</option>
                <option value="ditolak">Ditolak</option>
                <option value="tertunda">Tertunda (Memerlukan Maklumat Tambahan)</option>
            </select>
            @error('status_persetujuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="ulasan" class="form-label">Ulasan</label>
            <textarea class="form-control @error('ulasan') is-invalid @enderror" id="ulasan" name="ulasan" rows="4" placeholder="Masukkan ulasan atau alasan keputusan anda">{{ old('ulasan') }}</textarea>
            @error('ulasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-orange">Hantar Keputusan</button>
            <a href="{{ route('pengurusan.pengurusan_risiko.index') }}" class="btn btn-grey">Batal</a>
        </div>
    </form>
</div>

@endsection
