@extends('layouts.app-layout')

@section('title', 'Maklumat Risiko')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Maklumat Risiko</h2>
        <p>{{ $risk->nama_risiko }}</p>
    </div>
    <div>
        <a href="{{ route('entiti.pengurusan_risiko.edit', $risk->id) }}" class="btn btn-warning btn-sm">Edit</a>
        <form method="POST" action="{{ route('entiti.pengurusan_risiko.destroy', $risk->id) }}" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Adakah anda pasti?')">Hapus</button>
        </form>
    </div>
</div>

<a href="{{ route('entiti.pengurusan_risiko.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Details Card -->
<div class="card-box">
    <h5>Butiran Risiko</h5>

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
            <p class="mb-0">{{ $risk->created_at?->format('d/m/Y H:i') ?? '-' }}</p>
        </div>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center">
        <small class="text-muted">Dikemas kini: {{ $risk->updated_at?->format('d/m/Y H:i') ?? '-' }}</small>
        <a href="{{ route('entiti.pengurusan_risiko.index') }}" class="btn btn-sm btn-secondary">Kembali ke Senarai</a>
    </div>
</div>

@endsection
