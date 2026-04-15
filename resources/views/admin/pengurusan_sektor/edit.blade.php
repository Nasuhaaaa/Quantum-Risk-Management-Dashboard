@extends('layouts.app-layout')

@section('title', 'Ubah Sektor')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Ubah Sektor</h2>
        <p>{{ $sector->nama_sektor }}</p>
    </div>
</div>

<a href="{{ route('admin.pengurusan_sektor.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Form Card -->
<div class="card-box">
    <form method="POST" action="{{ route('admin.pengurusan_sektor.update', $sector->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_sektor" class="form-label">Nama Sektor</label>
                <input type="text" class="form-control @error('nama_sektor') is-invalid @enderror"
                       id="nama_sektor" name="nama_sektor" value="{{ old('nama_sektor', $sector->nama_sektor) }}" required>
                @error('nama_sektor')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="pengurus_sektor" class="form-label">Pengurus Sektor</label>
                <input type="text" class="form-control @error('pengurus_sektor') is-invalid @enderror"
                       id="pengurus_sektor" name="pengurus_sektor" value="{{ old('pengurus_sektor', $sector->pengurus_sektor) }}">
                @error('pengurus_sektor')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email Pengurus</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email', $sector->email) }}">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="no_telefon" class="form-label">No. Telefon</label>
                <input type="tel" class="form-control @error('no_telefon') is-invalid @enderror"
                       id="no_telefon" name="no_telefon" value="{{ old('no_telefon', $sector->no_telefon) }}">
                @error('no_telefon')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="">Pilih Status</option>
                    <option value="aktif" {{ old('status', $sector->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status', $sector->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control @error('keterangan') is-invalid @enderror"
                      id="keterangan" name="keterangan" rows="4">{{ old('keterangan', $sector->keterangan) }}</textarea>
            @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-orange">Kemaskini</button>
            <a href="{{ route('admin.pengurusan_sektor.index') }}" class="btn btn-grey">Batal</a>
        </div>
    </form>
</div>

@endsection
