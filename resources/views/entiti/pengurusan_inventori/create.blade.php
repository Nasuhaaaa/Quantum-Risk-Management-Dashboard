@extends('layouts.app-layout')

@section('title', 'Tambah Inventori')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Tambah Inventori Risiko</h2>
        <p>Daftarkan inventori baru</p>
    </div>
</div>

<a href="{{ route('entiti.pengurusan_inventori.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Form Card -->
<div class="card-box">
    <form action="{{ route('entiti.pengurusan_inventori.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="jenis_aset">Jenis Aset</label>
            <input type="text" name="jenis_aset" id="jenis_aset" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="nama_aset">Nama Aset</label>
            <input type="text" name="nama_aset" id="nama_aset" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="lokasi_pemilik">Lokasi Pemilik</label>
            <input type="text" name="lokasi_pemilik" id="lokasi_pemilik" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="sistem_legasi">Sistem Legasi</label>
            <input type="text" name="sistem_legasi" id="sistem_legasi" class="form-control">
        </div>

        <div class="form-group">
            <label for="catatan">Catatan</label>
            <textarea name="catatan" id="catatan" class="form-control" placeholder="Optional"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

@endsection
