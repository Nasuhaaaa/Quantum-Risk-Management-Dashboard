@extends('layouts.app-layout')

@section('title', 'Daftar Entiti Baru')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Tambah Entiti</h2>
        <p>Pendaftaran Entiti (Agensi) Baru</p>
    </div>
</div>

<a href="{{ route('admin.pengurusan_entiti.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Form Card -->
<div class="card-box">
    <h5>Borang Pendaftaran Entiti</h5>

    <form method="POST" action="{{ route('admin.pengurusan_entiti.store') }}">
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

        <div class="mb-3">
            <label for="id_sektor" class="form-label">Sektor</label>
            <select class="form-select @error('id_sektor') is-invalid @enderror" id="id_sektor" name="id_sektor" required>
                <option value="">Pilih Sektor</option>
                @foreach($sectors as $sector)
                    <option value="{{ $sector->id }}" {{ old('id_sektor') == $sector->id ? 'selected' : '' }}>
                        {{ $sector->nama_sektor }}
                    </option>
                @endforeach
            </select>
            @error('id_sektor')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <hr>

        <h6 class="mb-3">Maklumat Pegawai Utama</h6>

        <div class="mb-3">
            <label for="pic_nama" class="form-label">Nama Pegawai Utama (PIC)</label>
            <input type="text" class="form-control @error('pic_nama') is-invalid @enderror" id="pic_nama" name="pic_nama" value="{{ old('pic_nama') }}" required>
            @error('pic_nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="pic_telefon" class="form-label">No. Telefon PIC</label>
                    <input type="tel" class="form-control @error('pic_telefon') is-invalid @enderror" id="pic_telefon" name="pic_telefon" value="{{ old('pic_telefon') }}" required>
                    @error('pic_telefon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="pic_email" class="form-label">Email PIC</label>
                    <input type="email" class="form-control @error('pic_email') is-invalid @enderror" id="pic_email" name="pic_email" value="{{ old('pic_email') }}" required>
                    @error('pic_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
            @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-orange">Simpan</button>
            <a href="{{ route('admin.pengurusan_entiti.index') }}" class="btn btn-grey">Batal</a>
        </div>
    </form>
</div>

@endsection
