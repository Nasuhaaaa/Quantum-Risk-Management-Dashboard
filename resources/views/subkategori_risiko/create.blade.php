@extends('layouts.app-layout')

@section('title', 'Tambah Subkategori Risiko')

@section('content')

<div class="mb-3">
    {{-- <strong>Entiti: Bank Negara Malaysia</strong><br>
    <small>Sektor: Kewangan</small> --}}
</div>

<div class="card-box">

    <h5 class="text-center fw-bold text-warning mb-4">
        SUBKATEGORI RISIKO
    </h5>

    <form method="POST" action="{{ route('subkategori_risiko.store') }}">
        @csrf

        <!-- Maklumat CBOM -->
        <div class="section-title">Subkategori Risiko</div>

         <div class="mb-3">
            <label>Kategori Risiko</label>
            <select class="form-select" name="kategori_risiko_id">
                <option value="">Pilih Kategori Risiko</option>

                @foreach($kategoriRisiko as $item)
                    <option value="{{ $item->id }}"
                        {{ old('kategori_risiko_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->kategori_risiko }}
                    </option>
                @endforeach
            </select>
        </div>


       <div class="mb-3">
            <label>Subkategori Risiko</label>

            <input type="text"
            name="sub_kategori_risiko"
            class="form-control"
            value="{{ old('sub_kategori_risiko') }}">
            @error('sub_kategori_risiko')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


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
