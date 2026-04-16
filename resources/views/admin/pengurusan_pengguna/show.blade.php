@extends('layouts.app-layout')

@section('title', 'Lihat Pengguna')

@section('content')

<div class="dashboard-header">
    <div>
        <h2>Lihat Butiran Pengguna</h2>
        <p>{{ $user->username }}</p>
    </div>
</div>

<a href="{{ route('admin.pengurusan_pengguna.index') }}" class="btn btn-sm btn-secondary mb-3">Kembali</a>

<div class="card-box">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Nama Pengguna</label>
            <p class="mb-0">{{ $user->username }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Jenis Pengguna</label>
            <p class="mb-0">
                <span class="badge bg-primary">{{ $user->jenisPengguna?->jenis_pengguna ?? '-' }}</span>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Agensi</label>
            <p class="mb-0">{{ $user->agensi?->nama_agensi ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Tarikh Daftar</label>
            <p class="mb-0">{{ $user->created_at?->format('d/m/Y H:i') ?? '-' }}</p>
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
