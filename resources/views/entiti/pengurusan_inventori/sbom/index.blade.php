@extends('layouts.app-layout')

@section('title', 'Senarai SBOM')

@section('content')
<div class="dashboard-header">
    <div>
        <h2>Senarai SBOM</h2>
        <p>Pilih SBOM untuk meneruskan proses daftar risiko.</p>
    </div>
</div>

<div class="row g-4">
    @foreach($sboms as $sbom)
        <div class="col-lg-4">
            <div class="card-box">
                <h5>{{ $sbom->nama_sbom }}</h5>
                <p>{{ $sbom->deskripsi }}</p>
                <a href="{{ route('entiti.pengurusan_risiko.cbom', ['sbom_id' => $sbom->id]) }}" class="btn btn-primary">Pilih SBOM</a>
            </div>
        </div>
    @endforeach
</div>

<!-- SBOM Details Section -->
<div class="card-box mt-4">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Komponen Versi</label>
            <p class="mb-0">{{ $sbom->komponen_versi }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Sub Komponen</label>
            <p class="mb-0">{{ $sbom->sub_komponen }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">URL</label>
            <p class="mb-0">{{ $sbom->url }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Mod Perkhidmatan</label>
            <p class="mb-0">{{ $sbom->mod_perkhidmatan }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Language/Framework</label>
            <p class="mb-0">{{ $sbom->language_framework }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Modules/Libraries</label>
            <p class="mb-0">{{ $sbom->modules_libraries }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">External APIs/Services</label>
            <p class="mb-0">{{ $sbom->external_apis_services }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">In-House Vendor</label>
            <p class="mb-0">{{ $sbom->in_house_vendor }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Nama Vendor</label>
            <p class="mb-0">{{ $sbom->nama_vendor }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Kepakaran Kriptografi</label>
            <p class="mb-0">{{ $sbom->kepakaran_kriptografi }}</p>
        </div>
    </div>
</div>

<!-- CBOM List Section -->
<div class="card-box mt-4">
    <h5>Senarai CBOM</h5>

    @if($cboms->isEmpty())
        <p class="text-muted">Tiada CBOM yang berkaitan dengan SBOM ini.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama CBOM</th>
                        <th>Deskripsi</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cboms as $index => $cbom)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $cbom->nama_cbom }}</td>
                            <td>{{ $cbom->deskripsi }}</td>
                            <td>
                                <a href="{{ route('entiti.pengurusan_inventori.detail_cbom', ['cbom_id' => $cbom->id]) }}" class="btn btn-primary btn-sm">Lihat Butiran</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
