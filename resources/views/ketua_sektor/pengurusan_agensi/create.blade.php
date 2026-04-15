@extends('layouts.app-layout')

@section('title', 'Daftar Entiti Baru')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Tambah Entiti</h2>
        <p>Pendaftaran Entiti Baru dalam Sektor Anda</p>
    </div>
</div>

<a href="{{ route('sektor.pengurusan_agensi.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Form Card -->
<div class="card-box">
    <h5>Borang Pendaftaran Entiti</h5>

    <form method="POST" action="{{ route('sektor.pengurusan_agensi.store') }}">
        @csrf

        <div class="mb-3">
            <label for="nama_agensi" class="form-label">Nama Agensi</label>
            <input type="text" class="form-control @error('nama_agensi') is-invalid @enderror" id="nama_agensi" name="nama_agensi" value="{{ old('nama_agensi') }}" required>
            @error('nama_agensi')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="no_tel_agensi" class="form-label">No. Telefon Agensi</label>
                    <input type="tel" class="form-control @error('no_tel_agensi') is-invalid @enderror" id="no_tel_agensi" name="no_tel_agensi" value="{{ old('no_tel_agensi') }}" required>
                    @error('no_tel_agensi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input type="url" class="form-control @error('website') is-invalid @enderror" id="website" name="website" value="{{ old('website') }}">
                    @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <hr>

        <h6 class="mb-3">Maklumat Pegawai Utama</h6>

        <div class="mb-3">
            <label for="nama_pic" class="form-label">Nama Pegawai Utama (PIC)</label>
            <input type="text" class="form-control @error('nama_pic') is-invalid @enderror" id="nama_pic" name="nama_pic" value="{{ old('nama_pic') }}" required>
            @error('nama_pic')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="no_tel_pic" class="form-label">No. Telefon PIC</label>
                    <input type="tel" class="form-control @error('no_tel_pic') is-invalid @enderror" id="no_tel_pic" name="no_tel_pic" value="{{ old('no_tel_pic') }}" required>
                    @error('no_tel_pic')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="emel_pic" class="form-label">Email PIC</label>
                    <input type="email" class="form-control @error('emel_pic') is-invalid @enderror" id="emel_pic" name="emel_pic" value="{{ old('emel_pic') }}" required>
                    @error('emel_pic')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-orange">Simpan</button>
            <a href="{{ route('sektor.pengurusan_agensi.index') }}" class="btn btn-grey">Batal</a>
        </div>
    </form>
</div>

@endsection
