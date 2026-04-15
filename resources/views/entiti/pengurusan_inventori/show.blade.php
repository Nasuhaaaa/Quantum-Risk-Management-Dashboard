@extends('layouts.app-layout')

@section('title', 'Lihat Inventori')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Lihat Butiran Inventori</h2>
        <p>{{ $inventory->nama_inventori }}</p>
    </div>
</div>

<a href="{{ route('entiti.pengurusan_inventori.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Inventory Details Card -->
<div class="card-box">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Nama Inventori</label>
            <p class="mb-0">{{ $inventory->nama_inventori }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Kategori</label>
            <p class="mb-0">{{ $inventory->kategori ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Bilangan</label>
            <p class="mb-0"><span class="badge bg-secondary">{{ $inventory->bilangan ?? 0 }}</span></p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Lokasi</label>
            <p class="mb-0">{{ $inventory->lokasi ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Status</label>
            <p class="mb-0">
                @if($inventory->status === 'aktif')
                    <span class="badge bg-success">Aktif</span>
                @else
                    <span class="badge bg-secondary">Tidak Aktif</span>
                @endif
            </p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Tarikh Daftar</label>
            <p class="mb-0">{{ $inventory->created_at?->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    @if($inventory->keterangan)
    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="form-label text-muted">Keterangan</label>
            <p class="mb-0">{{ $inventory->keterangan }}</p>
        </div>
    </div>
    @endif

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('entiti.pengurusan_inventori.edit', $inventory->id) }}" class="btn btn-warning">Ubah</a>
        <form method="POST" action="{{ route('entiti.pengurusan_inventori.destroy', $inventory->id) }}" style="display:inline;" onsubmit="return confirm('Adakah anda pasti?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Padam</button>
        </form>
        <a href="{{ route('entiti.pengurusan_inventori.index') }}" class="btn btn-grey">Tutup</a>
    </div>
</div>

@endsection
