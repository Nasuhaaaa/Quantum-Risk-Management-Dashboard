@extends('layouts.app-layout')

@section('title', 'Tambah Kategori Punca Risiko')

@section('content')

<div class="mb-3">
    {{-- <strong>Entiti: Bank Negara Malaysia</strong><br>
    <small>Sektor: Kewangan</small> --}}
</div>

<div class="card-box">

    <h5 class="text-center fw-bold text-warning mb-4">
        KATEGORI RISIKO
    </h5>

    <form method="POST" action="{{ route('kategori_punca_risiko.store') }}">
        @csrf

        <!-- Maklumat CBOM -->
        <div class="section-title">Kategori Punca Risiko</div>

       <div class="mb-3">
            <input type="text"
            name="kategori_punca_risiko"
            class="form-control"
            value="{{ old('kategori_punca_risiko') }}">
            @error('kategori_punca_risiko')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <!-- Buttons -->
        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-orange">Simpan & Hantar</button>
            <button type="reset" class="btn btn-grey">Reset</button>
        </div>

    </form>
    @if(session('success'))
        <div class="alert alert-success mt-4">
            {{ session('success') }}
        </div>
    @endif

</div>

@endsection
