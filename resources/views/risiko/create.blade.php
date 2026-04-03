@extends('layouts.app-layout')

@section('title', 'Tambah Risiko')

@section('content')

<div class="mb-3">
    {{-- <strong>Entiti: Bank Negara Malaysia</strong><br>
    <small>Sektor: Kewangan</small> --}}
</div>

<div class="card-box">

    <h5 class="text-center fw-bold text-warning mb-4">
        SUBKATEGORI RISIKO
    </h5>

    <form method="POST" action="{{ route('risiko.store') }}">
        @csrf

        <!-- Maklumat CBOM -->
        <div class="section-title">Risiko</div>

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
           <select class="form-select" name="sub_kategori_risiko_id">
                <option value="">Pilih Subkategori Risiko</option>

                @foreach($subKategoriRisiko as $item)
                    <option
                        value="{{ $item->id }}"
                        data-kategori="{{ $item->kategori_risiko_id }}"
                        {{ old('sub_kategori_risiko_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->sub_kategori_risiko }}
                    </option>
                @endforeach
            </select>
        </div>


       <div class="mb-3">
            <label>Risiko</label>

            <input type="text"
            name="nama_risiko"
            class="form-control"
            value="{{ old('nama_risiko') }}">
            @error('nama_risiko')
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

<script>
    const kategori = document.querySelector('[name="kategori_risiko_id"]');
    const sub = document.querySelector('[name="sub_kategori_risiko_id"]');

    function filterSub() {
        const selected = kategori.value;

        Array.from(sub.options).forEach(option => {
            if (!option.value) return;

            const kategoriId = option.getAttribute('data-kategori');

            option.style.display = (kategoriId === selected) ? 'block' : 'none';
        });

        // reset if mismatch
        sub.value = '';
    }

    kategori.addEventListener('change', filterSub);

    // run on load (for old values)
    window.addEventListener('load', filterSub);
</script>

@endsection
