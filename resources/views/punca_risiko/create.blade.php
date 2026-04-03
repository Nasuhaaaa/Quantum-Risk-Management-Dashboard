@extends('layouts.app-layout')

@section('title', 'Tambah Punca Risiko')

@section('content')

<div class="mb-3">
    {{-- <strong>Entiti: Bank Negara Malaysia</strong><br>
    <small>Sektor: Kewangan</small> --}}
</div>

<div class="card-box">

    <h5 class="text-center fw-bold text-warning mb-4">
        PUNCA RISIKO
    </h5>

    <form method="POST" action="{{ route('punca_risiko.store') }}">
        @csrf

        <!-- Maklumat CBOM -->
        <div class="section-title">Subkategori Risiko</div>

         <div class="mb-3">
            <label>Kategori Risiko</label>
            <select class="form-select" name="kategori_punca_risiko_id">
                <option value="">Pilih Kategori Risiko</option>

                @foreach($kategoriPuncaRisiko as $item)
                    <option value="{{ $item->id }}"
                        {{ old('kategori_punca_risiko_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->kategori_punca_risiko }}
                    </option>
                @endforeach
            </select>
        </div>


       <div class="mb-3">
            <label>Punca Risiko</label>

            <input type="text"
            name="punca_risiko"
            class="form-control"
            value="{{ old('punca_risiko') }}">
            @error('punca_risiko')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

            <div class="mb-3">
                <label>Pelan Mitigasi</label>

                <input type="text"
                name="pelan_mitigasi"
                class="form-control"
                value="{{ old('pelan_mitigasi') }}">
                @error('pelan_mitigasi')
                    <div class="text-danger">{{ $message }}</div>
                @enderror


        <!-- Buttons -->
        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-orange">Simpan & Hantar</button>
            <button type="reset" class="btn btn-grey">Reset</button>
        </div>

    </form>

    @if(@session('success'))
        <div class="alert alert-success mt-4">
            {{ session('success') }}
        </div>
    @endif

</div>

@endsection
