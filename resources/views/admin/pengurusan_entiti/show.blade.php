@extends('layouts.app-layout')

@section('title', 'Lihat Entiti/Agensi')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Lihat Butiran Entiti/Agensi</h2>
        <p>{{ $entity->nama_agensi }}</p>
    </div>
</div>

<a href="{{ route('admin.pengurusan_entiti.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Entity Details Card -->
<div class="card-box">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Nama Agensi</label>
            <p class="mb-0">{{ $entity->nama_agensi }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Sektor</label>
            <p class="mb-0">{{ $entity->sektor?->nama_sektor ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Nama PIC</label>
            <p class="mb-0">{{ $entity->pic_nama ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Email PIC</label>
            <p class="mb-0">{{ $entity->pic_email ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Telefon PIC</label>
            <p class="mb-0">{{ $entity->pic_telefon ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Status</label>
            <p class="mb-0">
                @if($entity->status === 'aktif')
                    <span class="badge bg-success">Aktif</span>
                @else
                    <span class="badge bg-secondary">Tidak Aktif</span>
                @endif
            </p>
        </div>
    </div>

    @if($entity->keterangan)
    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="form-label text-muted">Keterangan</label>
            <p class="mb-0">{{ $entity->keterangan }}</p>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Tarikh Daftar</label>
            <p class="mb-0">{{ $entity->created_at?->format('d/m/Y H:i') }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Pengguna Terdaftar</label>
            <p class="mb-0"><span class="badge bg-secondary">{{ $entity->users?->count() ?? 0 }}</span></p>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('admin.pengurusan_entiti.edit', $entity->id) }}" class="btn btn-warning">Ubah</a>
        <form method="POST" action="{{ route('admin.pengurusan_entiti.destroy', $entity->id) }}" style="display:inline;" onsubmit="return confirm('Adakah anda pasti?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Padam</button>
        </form>
        <a href="{{ route('admin.pengurusan_entiti.index') }}" class="btn btn-grey">Tutup</a>
    </div>
</div>

@endsection
