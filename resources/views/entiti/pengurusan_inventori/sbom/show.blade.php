@extends('layouts.app-layout')

@section('title', 'Butiran SBOM')

@section('content')
<div class="dashboard-header">
    <div>
        <h2>Butiran SBOM</h2>
        <p>Maklumat lengkap mengenai SBOM dan senarai CBOM berkaitan.</p>
    </div>
</div>

<!-- SBOM Details Section -->
<div class="card-box">
    <h5 class="mb-4">Maklumat SBOM</h5>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th class="text-muted">Komponen Versi</th>
                    <td>{{ $sbom->komponen_versi }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Sub Komponen</th>
                    <td>{{ $sbom->sub_komponen }}</td>
                </tr>
                <tr>
                    <th class="text-muted">URL</th>
                    <td>{{ $sbom->url }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Mod Perkhidmatan</th>
                    <td>{{ $sbom->mod_perkhidmatan }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Language/Framework</th>
                    <td>{{ $sbom->language_framework }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Modules/Libraries</th>
                    <td>{{ $sbom->modules_libraries }}</td>
                </tr>
                <tr>
                    <th class="text-muted">External APIs/Services</th>
                    <td>{{ $sbom->external_apis_services }}</td>
                </tr>
                <tr>
                    <th class="text-muted">In-House Vendor</th>
                    <td>{{ $sbom->in_house_vendor }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Nama Vendor</th>
                    <td>{{ $sbom->nama_vendor }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Kepakaran Kriptografi</th>
                    <td>{{ $sbom->kepakaran_kriptografi }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- CBOM List Section -->
<div class="card-box mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold">Senarai CBOM</h5>

        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('entiti.pengurusan_inventori.cbom.create', ['sbom_id' => $sbom->id]) }}" class="btn btn-orange w-100">Tambah CBOM</a>
        </div>
    </div>

    @if($cboms->isEmpty())
        <p class="text-muted">Tiada CBOM yang berkaitan dengan SBOM ini.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Primitif Kriptografi</th>
                        <th>Algoritma Kriptografi</th>
                        <th>Panjang Kunci</th>
                        <th>Tujuan Penggunaan</th>
                        <th>Library Modules</th>
                        <th>Kategori Data</th>
                        <th>Sokongan Crypto Agility</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cboms as $index => $cbom)
                        <tr class="clickable-row" data-href="{{ route('entiti.pengurusan_risiko.create', ['cbom_id' => $cbom->id]) }}" style="cursor: pointer; background-color: #f9f9f9;" onmouseover="this.style.backgroundColor='#e9ecef';" onmouseout="this.style.backgroundColor='#f9f9f9';">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $cbom->primitif_kriptografi }}</td>
                            <td>{{ $cbom->algoritma_kriptografi }}</td>
                            <td>{{ $cbom->panjang_kunci }}</td>
                            <td>{{ $cbom->tujuan_penggunaan }}</td>
                            <td>{{ $cbom->library_modules }}</td>
                            <td>{{ $cbom->kategori_data }}</td>
                            <td>{{ $cbom->sokongan_crypto_agility }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.clickable-row');
        rows.forEach(row => {
            row.addEventListener('click', function() {
                window.location.href = this.dataset.href;
            });
        });
    });
</script>

@endsection
