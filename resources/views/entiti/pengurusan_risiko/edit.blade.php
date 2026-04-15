@extends('layouts.app-layout')

@section('title', 'Edit Risiko')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Edit Risiko</h2>
        <p>Kemaskini Maklumat Risiko</p>
    </div>
</div>

<a href="{{ route('entiti.pengurusan_risiko.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Form Card -->
<div class="card-box">
    <h5>Borang Kemaskini Risiko</h5>

    <form method="POST" action="{{ route('entiti.pengurusan_risiko.update', $risk->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_risiko" class="form-label">Nama Risiko</label>
            <input type="text" class="form-control @error('nama_risiko') is-invalid @enderror" id="nama_risiko" name="nama_risiko" value="{{ old('nama_risiko', $risk->nama_risiko) }}" required>
            @error('nama_risiko')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="kategori_risiko_id" class="form-label">Kategori Risiko</label>
            <select class="form-select @error('kategori_risiko_id') is-invalid @enderror" id="kategori_risiko_id" name="kategori_risiko_id" required>
                <option value="">Pilih Kategori</option>
            </select>
            @error('kategori_risiko_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="pemilik_risiko" class="form-label">Pemilik Risiko</label>
            <input type="text" class="form-control @error('pemilik_risiko') is-invalid @enderror" id="pemilik_risiko" name="pemilik_risiko" value="{{ old('pemilik_risiko', $risk->pemilik_risiko) }}" required>
            @error('pemilik_risiko')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="tahap_risiko" class="form-label">Tahap Risiko</label>
            <select class="form-select @error('tahap_risiko') is-invalid @enderror" id="tahap_risiko" name="tahap_risiko" required>
                <option value="">Pilih Tahap</option>
                <option value="Sangat Rendah" {{ old('tahap_risiko', $risk->tahap_risiko) == 'Sangat Rendah' ? 'selected' : '' }}>Sangat Rendah</option>
                <option value="Rendah" {{ old('tahap_risiko', $risk->tahap_risiko) == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                <option value="Sederhana" {{ old('tahap_risiko', $risk->tahap_risiko) == 'Sederhana' ? 'selected' : '' }}>Sederhana</option>
                <option value="Tinggi" {{ old('tahap_risiko', $risk->tahap_risiko) == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                <option value="Sangat Tinggi" {{ old('tahap_risiko', $risk->tahap_risiko) == 'Sangat Tinggi' ? 'selected' : '' }}>Sangat Tinggi</option>
            </select>
            @error('tahap_risiko')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-orange">Kemas Kini</button>
            <a href="{{ route('entiti.pengurusan_risiko.index') }}" class="btn btn-grey">Batal</a>
        </div>
    </form>
</div>

@endsection
