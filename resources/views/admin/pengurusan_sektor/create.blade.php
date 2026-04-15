@extends('layouts.app-layout')

@section('title', 'Daftar Sektor Baru')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Tambah Sektor</h2>
        <p>Pendaftaran Sektor Baru</p>
    </div>
</div>

<a href="{{ route('admin.pengurusan_sektor.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Form Card -->
<div class="card-box">
    <h5>Borang Pendaftaran Sektor</h5>

    <form method="POST" action="{{ route('admin.pengurusan_sektor.store') }}">
        @csrf

        <div class="mb-3">
            <label for="nama_sektor" class="form-label">Nama Sektor</label>
            <input type="text" class="form-control @error('nama_sektor') is-invalid @enderror" id="nama_sektor" name="nama_sektor" value="{{ old('nama_sektor') }}" required>
            @error('nama_sektor')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="keterangan_sektor" class="form-label">Keterangan Sektor</label>
            <textarea class="form-control @error('keterangan_sektor') is-invalid @enderror" id="keterangan_sektor" name="keterangan_sektor" rows="3">{{ old('keterangan_sektor') }}</textarea>
            @error('keterangan_sektor')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="ketua_sektor" class="form-label">Ketua Sektor</label>
            <input type="text" class="form-control @error('ketua_sektor') is-invalid @enderror" id="ketua_sektor" name="ketua_sektor" value="{{ old('ketua_sektor') }}">
            @error('ketua_sektor')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="maklumat_perhubungan_sektor" class="form-label">Maklumat Perhubungan Sektor</label>
            <textarea class="form-control @error('maklumat_perhubungan_sektor') is-invalid @enderror" id="maklumat_perhubungan_sektor" name="maklumat_perhubungan_sektor" rows="3">{{ old('maklumat_perhubungan_sektor') }}</textarea>
            @error('maklumat_perhubungan_sektor')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-orange">Simpan</button>
            <a href="{{ route('admin.pengurusan_sektor.index') }}" class="btn btn-grey">Batal</a>
        </div>
    </form>
</div>

@endsection
