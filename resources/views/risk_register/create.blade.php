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

<form method="POST" action="{{ route('risk_register.store') }}">
    @csrf

    <!-- Hidden CBOM ID -->
    @if($cbom)
        <input type="hidden" name="cbom_id" value="{{ $cbom->id }}">
    @endif

    <!-- Maklumat CBOM Section -->
    <div class="card-box mb-4">
        <h5 class="mb-3">Maklumat CBOM</h5>

        @if($cbom)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="text-muted">Nama Aset</th>
                            <td>{{ $cbom->sbom?->inventori?->nama_aset }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">ID SBOM</th>
                            <td>{{ $cbom->sbom?->id }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">ID CBOM</th>
                            <td>{{ $cbom->id }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Algoritma Kriptografi</th>
                            <td>{{ $cbom->algoritma_kriptografi }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Panjang Kunci</th>
                            <td>{{ $cbom->panjang_kunci }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Tujuan Penggunaan</th>
                            <td>{{ $cbom->tujuan_penggunaan }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Library/Modules</th>
                            <td>{{ $cbom->library_modules }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Kategori Data</th>
                            <td>{{ $cbom->kategori_data }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Sokongan Crypto Agility</th>
                            <td>{{ $cbom->sokongan_crypto_agility }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">Tiada maklumat CBOM yang tersedia.</p>
        @endif
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
            <input type="text" class="form-control" name="pemilik_risiko" required>
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
            <select class="form-select" name="impak_id">
                <option value="">Pilih Impak</option>

                @foreach($impak as $item)
                    <option value="{{ $item->impak_id }}"
                        data-skala="{{ $item->skala }}"
                        {{ old('impak_id') == $item->impak_id ? 'selected' : '' }}>
                        {{ $item->tahap }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Kemungkinan</label>
            <select class="form-select" name="kebarangkalian_id">
                <option value="">Pilih Kemungkinan</option>

                @foreach($kebarangkalian as $item)
                    <option value="{{ $item->kebarangkalian_id }}"
                        data-skala="{{ $item->skala }}"
                        {{ old('kebarangkalian_id') == $item->kebarangkalian_id ? 'selected' : '' }}>
                        {{ $item->tahap }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Skor Risiko</label>
            <input type="text" class="form-control" id="skor_risiko" name="skor_risiko" readonly>
        </div>

        <div class="mb-3">
            <label>Tahap Risiko</label>
            <input type="text" class="form-control" id="tahap_risiko" readonly>
            <input type="hidden" id="tahap_risiko_id" name="tahap_risiko_id">
        </div>
    </div>

    <!-- Kawalan Section -->
    <div class="card-box mb-4">
        <h5 class="mb-3">Kawalan</h5>

        <div class="mb-3">
            <label>Kawalan Sedia Ada</label>
            <input type="text" class="form-control" name="kawalan_sedia_ada">
        </div>

        <div class="mb-3">
            <label>Pelan Mitigasi</label>
            <input type="text" class="form-control" id="pelan_mitigasi" name="pelan_mitigasi" readonly>
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
        populatePelanMitigasi();
    }

    function populatePelanMitigasi() {
        const selectedPuncaId = punca.value;
        const pelanMitigasiInput = document.querySelector('#pelan_mitigasi');

        if (!selectedPuncaId) {
            pelanMitigasiInput.value = '';
            return;
        }

        const puncaData = @json($puncaRisiko);
        const selected = puncaData.find(item => item.id == selectedPuncaId);

        pelanMitigasiInput.value = selected ? selected.pelan_mitigasi : '';
    }

    kategori.addEventListener('change', filterSub);
    sub.addEventListener('change', filterRisiko);
    kategoriPunca.addEventListener('change', filterPunca);
    punca.addEventListener('change', populatePelanMitigasi);

    window.addEventListener('load', () => {
        filterSub();
        filterRisiko();
        filterPunca();
        populatePelanMitigasi();
    });

    // Calculate skor risiko based on impak x kebarangkalian
    const impakSelect = document.querySelector('[name="impak_id"]');
    const kebarangkalianSelect = document.querySelector('[name="kebarangkalian_id"]');
    const skorRisikoInput = document.querySelector('#skor_risiko');
    const tahapRisikoInput = document.querySelector('#tahap_risiko');

    // TahapRisiko data from database
    const tahapRisikoData = @json($tahapRisiko);

    // Color mapping for risk levels
    const colorMap = {
        'Sangat Rendah': '#C8E6C9',      // Pastel Green
        'Rendah': '#FFF9C4',              // Pastel Yellow
        'Sederhana': '#FFE0B2',           // Pastel Orange
        'Tinggi': '#FFCDD2',              // Pastel Red
        'Sangat Tinggi': '#E8A4A4'        // Pastel Dark Red
    };

    function calculateSkorRisiko() {
        const impakOption = impakSelect.options[impakSelect.selectedIndex];
        const kebarangkalianOption = kebarangkalianSelect.options[kebarangkalianSelect.selectedIndex];

        if (!impakOption.value || !kebarangkalianOption.value) {
            skorRisikoInput.value = '';
            tahapRisikoInput.value = '';
            tahapRisikoInput.style.backgroundColor = '';
            tahapRisikoInput.style.color = '';
            return;
        }

        const impakSkala = parseInt(impakOption.getAttribute('data-skala'));
        const kebarangkalianSkala = parseInt(kebarangkalianOption.getAttribute('data-skala'));

        const skor = impakSkala * kebarangkalianSkala;
        skorRisikoInput.value = skor;

        // Lookup tahap risiko from table based on skor range
        const tahapRisiko = tahapRisikoData.find(item =>
            skor >= item.skor_min && skor <= item.skor_max
        );

        const tahapValue = tahapRisiko ? tahapRisiko.tahap_risiko : '';
        tahapRisikoInput.value = tahapValue;

        // Set tahap_risiko_id hidden field
        const tahapRisikoIdInput = document.querySelector('#tahap_risiko_id');
        tahapRisikoIdInput.value = tahapRisiko ? tahapRisiko.tahap_risiko_id : '';

        // Set background color based on tahap
        const bgColor = colorMap[tahapValue] || '';
        tahapRisikoInput.style.backgroundColor = bgColor;

        // Set text color to black for better readability
        tahapRisikoInput.style.color = '#000';
    }

    impakSelect.addEventListener('change', calculateSkorRisiko);
    kebarangkalianSelect.addEventListener('change', calculateSkorRisiko);

    window.addEventListener('load', () => {
        filterSub();
        filterRisiko();
        filterPunca();
        calculateSkorRisiko();
    });

</script>

@endsection
