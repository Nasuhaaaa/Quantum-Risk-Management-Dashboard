@extends('layouts.app-layout')

@section('title', 'Lihat Pengguna')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Lihat Butiran Pengguna</h2>
        <p>{{ $user->nama_lengkap }}</p>
    </div>
</div>

<a href="{{ route('admin.pengurusan_pengguna.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- User Details Card -->
<div class="card-box">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Nama Lengkap</label>
            <p class="mb-0">{{ $user->nama_lengkap }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Email</label>
            <p class="mb-0">{{ $user->email }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">No. Telefon</label>
            <p class="mb-0">{{ $user->no_telefon ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Jenis Pengguna</label>
            <p class="mb-0">
                @if($user->jenis_pengguna === 'entiti')
                    <span class="badge bg-primary">Entiti</span>
                @elseif($user->jenis_pengguna === 'ketua_sektor')
                    <span class="badge bg-success">Ketua Sektor</span>
                @elseif($user->jenis_pengguna === 'pengurusan')
                    <span class="badge bg-warning">Pengurusan</span>
                @elseif($user->jenis_pengguna === 'admin')
                    <span class="badge bg-danger">Admin</span>
                @endif
            </p>
        </div>
    </div>

    @if($user->jenis_pengguna === 'entiti' && $user->id_agensi)
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Agensi</label>
            <p class="mb-0">{{ $user->agensi?->nama_agensi ?? '-' }}</p>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Status</label>
            <p class="mb-0">
                @if($user->is_active)
                    <span class="badge bg-success">Aktif</span>
                @else
                    <span class="badge bg-secondary">Tidak Aktif</span>
                @endif
            </p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Tarikh Daftar</label>
            <p class="mb-0">{{ $user->created_at?->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('admin.pengurusan_pengguna.edit', $user->id) }}" class="btn btn-warning">Ubah</a>
        <form method="POST" action="{{ route('admin.pengurusan_pengguna.destroy', $user->id) }}" style="display:inline;" onsubmit="return confirm('Adakah anda pasti?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Padam</button>
        </form>
        <a href="{{ route('admin.pengurusan_pengguna.index') }}" class="btn btn-grey">Tutup</a>
    </div>
</div>

@endsection
