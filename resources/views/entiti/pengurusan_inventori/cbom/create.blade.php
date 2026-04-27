@extends('layouts.app-layout')

@section('title', 'Tambah CBOM')

@section('content')
<div class="dashboard-header mb-4">
    <div>
        <h2 class="fw-bold">Tambah CBOM</h2>
        <p class="text-muted">Daftarkan CBOM baru untuk SBOM</p>
    </div>
</div>

<a href="{{ route('entiti.pengurusan_inventori.sbom.show', ['sbom_id' => $sbom_id]) }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<div class="card-box p-4">
    <form action="{{ route('entiti.pengurusan_inventori.cbom.store', $sbom_id) }}" method="POST">
        @csrf

        <input type="hidden" name="sbom_id" value="{{ $sbom_id }}">

        <div class="form-group mb-4">
            <label for="primitif_kriptografi">Primitif Kriptografi</label>
            <input type="text" name="primitif_kriptografi" id="primitif_kriptografi" class="form-control">
        </div>

        <div class="form-group mb-4">
            <label for="algoritma_kriptografi">Algoritma Kriptografi</label>
            <input type="text" name="algoritma_kriptografi" id="algoritma_kriptografi" class="form-control">
        </div>

        <div class="form-group mb-4">
            <label for="panjang_kunci">Panjang Kunci</label>
            <input type="text" name="panjang_kunci" id="panjang_kunci" class="form-control">
        </div>

        <div class="form-group mb-4">
            <label for="tujuan_penggunaan">Tujuan Penggunaan</label>
            <textarea name="tujuan_penggunaan" id="tujuan_penggunaan" class="form-control"></textarea>
        </div>

        <div class="form-group mb-4">
            <label for="library_modules">Library/Modules</label>
            <textarea name="library_modules" id="library_modules" class="form-control"></textarea>
        </div>

        <div class="form-group mb-4">
            <label for="kategori_data">Kategori Data</label>
            <input type="text" name="kategori_data" id="kategori_data" class="form-control">
        </div>

        <div class="form-group mb-4">
            <label for="sokongan_crypto_agility">Sokongan Crypto Agility</label>
            <input type="text" name="sokongan_crypto_agility" id="sokongan_crypto_agility" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
