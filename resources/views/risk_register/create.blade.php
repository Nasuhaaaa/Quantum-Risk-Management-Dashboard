@extends('layouts.app-layout')

@section('title', 'Daftar Risiko')

@section('content')

<div class="mb-3">
    <strong>Entiti: Bank Negara Malaysia</strong><br>
    <small>Sektor: Kewangan</small>
</div>

<div class="card-box">

    <h5 class="text-center fw-bold text-warning mb-4">
        DAFTAR RISIKO KUANTUM NASIONAL
    </h5>

    <form method="POST" action="{{ route('risk_register.store') }}">
        @csrf

        <!-- Maklumat CBOM -->
        <div class="section-title">Maklumat CBOM</div>

       <div class="mb-3">
            <label>Maklumat CBOM</label>
            <select class="form-select"></select>
        </div>

        <!-- Maklumat Risiko -->
        <div class="section-title">Maklumat Risiko</div>

        <div class="mb-3">
            <label>Kategori Risiko</label>
            <select class="form-select"></select>
        </div>

        <div class="mb-3">
            <label>Subkategori Risiko</label>
            <select class="form-select"></select>
        </div>

         <div class="mb-3">
            <label>Risiko</label>
            <select class="form-select"></select>
        </div>

        <div class="mb-3">
            <label>Pemilik Risiko</label>
            <input type="text" class="form-control">
        </div>


        <!-- Penilaian Risiko -->
        <div class="section-title">Penilaian Risiko</div>

        <div class="mb-3">
            <label>Kategori Punca Risiko</label>
            <select class="form-select"></select>
        </div>

        <div class="mb-3">
            <label>Punca Risiko</label>
            <select class="form-select"></select>
        </div>

        <div class="mb-3">
            <label>Impak</label>
            <select class="form-select"></select>
        </div>

        <div class="mb-3">
            <label>Kemungkinan</label>
            <select class="form-select"></select>
        </div>

        <div class="mb-3">
            <label>Skor Risiko</label>
            {{-- <select class="form-select"></select> --}}
            {{-- nanti tukar readonly --}}
        </div>

        <div class="mb-3">
            <label>Tahap Risiko</label>
            {{-- <select class="form-select"></select> --}}
            {{-- nanti tukar readonly --}}
        </div>

        <!-- Kawalan -->
        <div class="section-title">Kawalan</div>

        <div class="mb-3">
            <label>Kawalan Sedia Ada</label>
            <input type="text" class="form-control">
        </div>

        {{-- nanti tukar readonly --}}
        <div class="mb-3">
            <label>Pelan Mitigasi</label>
            <input type="text" class="form-control">
        </div>



        <!-- Buttons -->
        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-orange">Simpan & Hantar</button>
            <button type="reset" class="btn btn-grey">Reset</button>
        </div>

    </form>

</div>

@endsection
