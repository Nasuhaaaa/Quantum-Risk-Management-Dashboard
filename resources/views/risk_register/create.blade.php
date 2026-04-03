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
           <select class="form-select" name="risiko_id">
                <option value="">Pilih Risiko</option>

                @foreach($risiko as $item)
                    <option
                        value="{{ $item->id }}"
                        data-sub="{{ $item->sub_kategori_risiko_id }}"
                        {{ old('risiko_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama_risiko }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Pemilik Risiko</label>
            <input type="text" class="form-control">
        </div>


        <!-- Penilaian Risiko -->
        <div class="section-title">Penilaian Risiko</div>

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
                <select class="form-select" name="punca_risiko_id">
                    <option value="">Pilih Punca Risiko</option>

                    @foreach($puncaRisiko as $item)
                        <option value="{{ $item->id }}"
                            data-kategori="{{ $item->kategori_punca_risiko_id }}"
                            {{ old('punca_risiko_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->punca_risiko }}
                        </option>
                    @endforeach
                </select>
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
        </div

    </form>

</div>

<script>
    // Risiko chain
    const kategori = document.querySelector('[name="kategori_risiko_id"]');
    const sub = document.querySelector('[name="sub_kategori_risiko_id"]');
    const risiko = document.querySelector('[name="risiko_id"]');

    // Punca chain
    const kategoriPunca = document.querySelector('[name="kategori_punca_risiko_id"]');
    const punca = document.querySelector('[name="punca_risiko_id"]');

    function filterSub() {
        const selected = kategori.value;

        Array.from(sub.options).forEach(option => {
            if (!option.value) return;

            const kategoriId = option.getAttribute('data-kategori');
            option.hidden = (kategoriId !== selected);
        });

        sub.value = '';
        filterRisiko();
    }

    function filterRisiko() {
        const selectedSub = sub.value;

        Array.from(risiko.options).forEach(option => {
            if (!option.value) return;

            const subId = option.getAttribute('data-sub');
            option.hidden = (subId !== selectedSub);
        });

        risiko.value = '';
    }

    function filterPunca() {
        const selectedKategori = kategoriPunca.value;

        Array.from(punca.options).forEach(option => {
            if (!option.value) return;

            const kategoriId = option.getAttribute('data-kategori');
            option.hidden = (kategoriId !== selectedKategori);
        });

        punca.value = '';
    }

    kategori.addEventListener('change', filterSub);
    sub.addEventListener('change', filterRisiko);
    kategoriPunca.addEventListener('change', filterPunca);

    window.addEventListener('load', () => {
        filterSub();
        filterRisiko();
        filterPunca();
    });
</script>

@endsection
