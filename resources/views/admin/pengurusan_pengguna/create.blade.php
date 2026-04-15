@extends('layouts.app-layout')

@section('title', 'Daftar Pengguna Baru')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Tambah Pengguna</h2>
        <p>Pendaftaran Pengguna Sistem Baru</p>
    </div>
</div>

<a href="{{ route('admin.pengurusan_pengguna.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Form Card -->
<div class="card-box">
    <h5>Borang Pendaftaran Pengguna</h5>

    <form method="POST" action="{{ route('admin.pengurusan_pengguna.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Kata Laluan</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Sahkan Kata Laluan</label>
            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
            @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="role_type" class="form-label">Jenis Pengguna</label>
            <select class="form-select @error('role_type') is-invalid @enderror" id="role_type" name="role_type" required>
                <option value="">Pilih Jenis Pengguna</option>
                <option value="admin">Sistem Admin</option>
                <option value="pengurusan">Pengurusan</option>
                <option value="ketua_sektor">Ketua Sektor</option>
                <option value="entiti">Entiti (Agensi)</option>
            </select>
            @error('role_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="agensi_id" class="form-label">Agensi (Opsional)</label>
            <select class="form-select @error('agensi_id') is-invalid @enderror" id="agensi_id" name="agensi_id">
                <option value="">Pilih Agensi</option>
                <!-- TODO: Load agensi from database -->
            </select>
            @error('agensi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-orange">Simpan</button>
            <a href="{{ route('admin.pengurusan_pengguna.index') }}" class="btn btn-grey">Batal</a>
        </div>
    </form>
</div>

@endsection
