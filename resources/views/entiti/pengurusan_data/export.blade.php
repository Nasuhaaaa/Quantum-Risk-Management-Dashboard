@extends('layouts.app-layout')

@section('title', 'Export Data Risiko')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Export Data Risiko</h2>
        <p>Muat turun data risiko ke file Excel</p>
    </div>
</div>

<a href="{{ route('entiti.pengurusan_data.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Export Options Card -->
<div class="card-box">
    <h5>Pilih Data untuk Diekspor</h5>

    <form method="POST" action="{{ route('entiti.pengurusan_data.export') }}">
        @csrf

        <div class="mb-4">
            <label class="form-label">Pilih Jenis Data</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="export_type" id="all_risks" value="all" checked>
                <label class="form-check-label" for="all_risks">
                    <strong>Semua Risiko</strong> - Eksport semua risiko yang didaftar
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="export_type" id="approved_risks" value="approved">
                <label class="form-check-label" for="approved_risks">
                    <strong>Risiko Diluluskan</strong> - Hanya risiko yang telah diluluskan
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="export_type" id="pending_risks" value="pending">
                <label class="form-check-label" for="pending_risks">
                    <strong>Risiko Menunggu</strong> - Hanya risiko yang masih menunggu keputusan
                </label>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Pilih Tahap Risiko</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="levels[]" id="tinggi" value="Tinggi" checked>
                <label class="form-check-label" for="tinggi">Tinggi</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="levels[]" id="sederhana" value="Sederhana" checked>
                <label class="form-check-label" for="sederhana">Sederhana</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="levels[]" id="rendah" value="Rendah" checked>
                <label class="form-check-label" for="rendah">Rendah</label>
            </div>
        </div>

        <div class="mb-4">
            <label for="date_from" class="form-label">Tarikh Mulai (Opsional)</label>
            <input type="date" class="form-control" id="date_from" name="date_from">
        </div>

        <div class="mb-4">
            <label for="date_to" class="form-label">Tarikh Sehingga (Opsional)</label>
            <input type="date" class="form-control" id="date_to" name="date_to">
        </div>

        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            File akan diekspor dalam format Excel (.xlsx) dan akan mengandungi semua butiran risiko termasuk punca-punca risiko dan rancangan mitigasi.
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-orange">
                <i class="fas fa-download"></i> Muat Turun Excel
            </button>
            <a href="{{ route('entiti.pengurusan_data.index') }}" class="btn btn-grey">Batal</a>
        </div>
    </form>
</div>

@endsection
