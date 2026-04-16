
@extends('layouts.app-layout')

@section('title', 'Tambah SBOM')

@section('content')
<div class="dashboard-header mb-4">
    <div>
        <h2 class="fw-bold">Tambah SBOM</h2>
        <p class="text-muted">Daftarkan SBOM baru untuk inventori</p>
    </div>
</div>

<a href="{{ route('entiti.pengurusan_inventori.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<div class="card-box p-4">
    <form action="{{ route('entiti.pengurusan_inventori.sbom.store', $inventori_id) }}" method="POST">
        @csrf

        <input type="hidden" name="inventori_id" value="{{ $inventori_id }}">

        <div class="form-group mb-4">
            <label for="komponen_versi">Komponen Versi</label>
            <input type="text" name="komponen_versi" id="komponen_versi" class="form-control">
        </div>

        <div class="form-group mb-4">
            <label for="sub_komponen">Sub Komponen</label>
            <textarea name="sub_komponen" id="sub_komponen" class="form-control"></textarea>
        </div>

        <div class="form-group mb-4">
            <label for="url">URL</label>
            <input type="text" name="url" id="url" class="form-control">
        </div>

        <div class="form-group mb-4">
            <label for="mod_perkhidmatan">Mod Perkhidmatan (Contoh: External, Internal, External dan Internal)</label>
            <input type="text" name="mod_perkhidmatan" id="mod_perkhidmatan" class="form-control">
        </div>

        <div class="form-group mb-4">
            <label for="language_framework">Language/Framework</label>
            <input type="text" name="language_framework" id="language_framework" class="form-control">
        </div>

        <div class="form-group mb-4">
            <label for="modules_libraries">Modules/Libraries</label>
            <textarea name="modules_libraries" id="modules_libraries" class="form-control"></textarea>
        </div>

        <div class="form-group mb-4">
            <label for="external_apis_services">External APIs/Services</label>
            <input type="text" name="external_apis_services" id="external_apis_services" class="form-control">
        </div>

        <div class="form-group mb-4">
            <label for="in_house_vendor">Pembangunan Aplikasi sistem In-House atau Vendor</label>
            <input type="text" name="in_house_vendor" id="in_house_vendor" class="form-control">
        </div>

        <div class="form-group mb-4">
            <label for="nama_vendor">Nama Vendor</label>
            <input type="text" name="nama_vendor" id="nama_vendor" class="form-control">
        </div>

        <div class="form-group mb-4">
            <label for="kepakaran_kriptografi">Kepakaran Kriptografi</label>
            <input type="text" name="kepakaran_kriptografi" id="kepakaran_kriptografi" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
