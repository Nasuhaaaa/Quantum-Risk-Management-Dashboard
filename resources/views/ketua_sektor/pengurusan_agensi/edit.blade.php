@extends('layouts.app-layout')

@section('title', 'Ubah Agensi')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Ubah Agensi</h2>
        <p>{{ $entity->nama_agensi }}</p>
    </div>
</div>

<a href="{{ route('sektor.pengurusan_agensi.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Form Card -->
<div class="card-box">
    <form method="POST" action="{{ route('sektor.pengurusan_agensi.update', $entity->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_agensi" class="form-label">Nama Agensi</label>
                <input type="text" class="form-control @error('nama_agensi') is-invalid @enderror"
                       id="nama_agensi" name="nama_agensi" value="{{ old('nama_agensi', $entity->nama_agensi) }}" required>
                @error('nama_agensi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="pic_nama" class="form-label">Nama PIC</label>
                <input type="text" class="form-control @error('pic_nama') is-invalid @enderror"
                       id="pic_nama" name="pic_nama" value="{{ old('pic_nama', $entity->pic_nama) }}">
                @error('pic_nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="pic_email" class="form-label">Email PIC</label>
                <input type="email" class="form-control @error('pic_email') is-invalid @enderror"
                       id="pic_email" name="pic_email" value="{{ old('pic_email', $entity->pic_email) }}">
                @error('pic_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="pic_telefon" class="form-label">Telefon PIC</label>
                <input type="tel" class="form-control @error('pic_telefon') is-invalid @enderror"
                       id="pic_telefon" name="pic_telefon" value="{{ old('pic_telefon', $entity->pic_telefon) }}">
                @error('pic_telefon')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="">Pilih Status</option>
                    <option value="aktif" {{ old('status', $entity->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status', $entity->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control @error('keterangan') is-invalid @enderror"
                      id="keterangan" name="keterangan" rows="4">{{ old('keterangan', $entity->keterangan) }}</textarea>
            @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-orange">Kemaskini</button>
            <a href="{{ route('sektor.pengurusan_agensi.index') }}" class="btn btn-grey">Batal</a>
        </div>
    </form>
</div>

@endsection
