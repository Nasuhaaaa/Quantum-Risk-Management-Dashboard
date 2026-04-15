@extends('layouts.app-layout')

@section('title', 'Ubah Inventori')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Ubah Inventori</h2>
        <p>{{ $inventory->nama_inventori }}</p>
    </div>
</div>

<a href="{{ route('entiti.pengurusan_inventori.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Form Card -->
<div class="card-box">
    <form method="POST" action="{{ route('entiti.pengurusan_inventori.update', $inventory->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_inventori" class="form-label">Nama Inventori</label>
                <input type="text" class="form-control @error('nama_inventori') is-invalid @enderror"
                       id="nama_inventori" name="nama_inventori" value="{{ old('nama_inventori', $inventory->nama_inventori) }}" required>
                @error('nama_inventori')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <input type="text" class="form-control @error('kategori') is-invalid @enderror"
                       id="kategori" name="kategori" value="{{ old('kategori', $inventory->kategori) }}">
                @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="bilangan" class="form-label">Bilangan</label>
                <input type="number" class="form-control @error('bilangan') is-invalid @enderror"
                       id="bilangan" name="bilangan" value="{{ old('bilangan', $inventory->bilangan) }}" min="0">
                @error('bilangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                       id="lokasi" name="lokasi" value="{{ old('lokasi', $inventory->lokasi) }}">
                @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="">Pilih Status</option>
                    <option value="aktif" {{ old('status', $inventory->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status', $inventory->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control @error('keterangan') is-invalid @enderror"
                      id="keterangan" name="keterangan" rows="4">{{ old('keterangan', $inventory->keterangan) }}</textarea>
            @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-orange">Kemaskini</button>
            <a href="{{ route('entiti.pengurusan_inventori.index') }}" class="btn btn-grey">Batal</a>
        </div>
    </form>
</div>

@endsection
