@extends('layouts.app-layout')

@section('title', 'Daftar Risiko')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Daftar Risiko</h2>
        <p>Daftar Risiko Kuantum Nasional</p>
    </div>
</div>

<a href="{{ route('entiti.pengurusan_risiko.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Entity Info -->
<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card-box">
            <h6>Entiti</h6>
            <p class="mb-0" style="font-size: 15px; font-weight: 600;">{{ auth()->user()->agensi?->nama_agensi ?? 'Bank Negara Malaysia' }}</p>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-box">
            <h6>Sektor</h6>
            <p class="mb-0" style="font-size: 15px; font-weight: 600;">{{ auth()->user()->agensi?->sektor?->nama_sektor ?? 'Kewangan' }}</p>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('entiti.pengurusan_risiko.store') }}">
    @csrf

    <!-- Maklumat CBOM Section -->
    <div class="card-box mb-4">
        <h5 class="mb-3">Maklumat CBOM</h5>

        <div class="mb-3">
            <label>Maklumat CBOM</label>
            <select class="form-select"></select>
        </div>
    </div>

    <!-- Maklumat Risiko Section -->
    <div class="card-box mb-4">
        <h5 class="mb-3">Maklumat Risiko</h5>

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
    </div>

    <!-- Penilaian Risiko Section -->
    <div class="card-box mb-4">
        <h5 class="mb-3">Penilaian Risiko</h5>

        <div class="mb-3">
            <label>Kategori Punca Risiko</label>
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
            <input type="text" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label>Tahap Risiko</label>
            <input type="text" class="form-control" readonly>
        </div>
    </div>

    <!-- Kawalan Section -->
    <div class="card-box mb-4">
        <h5 class="mb-3">Kawalan</h5>

        <div class="mb-3">
            <label>Kawalan Sedia Ada</label>
            <input type="text" class="form-control">
        </div>

        <div class="mb-3">
            <label>Pelan Mitigasi</label>
            <input type="text" class="form-control">
        </div>
    </div>

    <!-- Buttons -->
    <div class="d-flex justify-content-end gap-2 mb-4">
        <button type="submit" class="btn btn-orange">Simpan & Hantar</button>
        <button type="reset" class="btn btn-grey">Reset</button>
    </div>
</form>



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
