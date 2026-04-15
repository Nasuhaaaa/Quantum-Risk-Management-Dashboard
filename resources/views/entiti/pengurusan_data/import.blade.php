@extends('layouts.app-layout')

@section('title', 'Import Data Risiko')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Import Data Risiko</h2>
        <p>Muat naik data risiko dari file Excel</p>
    </div>
</div>

<a href="{{ route('entiti.pengurusan_data.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Instructions Card -->
<div class="card-box mb-4 bg-light">
    <h5>Format File Excel</h5>
    <p>File Excel anda mesti mempunyai kolom-kolom berikut:</p>
    <ul class="list-unstyled">
        <li><i class="fas fa-check text-success"></i> <strong>Nama Risiko</strong> - Nama risiko</li>
        <li><i class="fas fa-check text-success"></i> <strong>Pemilik Risiko</strong> - Nama pemilik risiko</li>
        <li><i class="fas fa-check text-success"></i> <strong>Kategori Risiko</strong> - Nama kategori</li>
        <li><i class="fas fa-check text-success"></i> <strong>Tahap Risiko</strong> - Tinggi/Sederhana/Rendah</li>
        <li><i class="fas fa-check text-success"></i> <strong>Kemungkinan</strong> - Nilai kemungkinan</li>
        <li><i class="fas fa-check text-success"></i> <strong>Kesan</strong> - Nilai kesan</li>
        <li><i class="fas fa-check text-success"></i> <strong>Penerangan</strong> - Penerangan risiko</li>
    </ul>

    <div class="mt-3">
        <a href="{{ route('entiti.pengurusan_data.downloadTemplate') }}" class="btn btn-sm btn-info">
            <i class="fas fa-download"></i> Muat Turun Template
        </a>
    </div>
</div>

<!-- Upload Form Card -->
<div class="card-box">
    <form method="POST" action="{{ route('entiti.pengurusan_data.import') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="file" class="form-label">Pilih File Excel</label>
            <input type="file" class="form-control @error('file') is-invalid @enderror"
                   id="file" name="file" accept=".xlsx,.xls,.csv" required>
            @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <small class="text-muted d-block mt-2">Format yang disokong: .xlsx, .xls, .csv (Saiz maksimum: 5MB)</small>
        </div>

        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            Sistem akan memvalidasi setiap baris. Jika terdapat ralat, anda akan menerima laporan terperinci.
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-orange">Muat Naik</button>
            <a href="{{ route('entiti.pengurusan_data.index') }}" class="btn btn-grey">Batal</a>
        </div>
    </form>
</div>

@endsection
