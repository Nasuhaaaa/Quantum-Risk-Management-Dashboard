@extends('layouts.app-layout')

@section('title', 'Butiran CBOM')

@section('content')
<div class="dashboard-header">
    <div>
        <h2>Butiran CBOM</h2>
        <p>Maklumat lengkap mengenai CBOM.</p>
    </div>
</div>

<!-- CBOM Details Section -->
<div class="card-box">
    <h5 class="mb-4">Maklumat CBOM</h5>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th class="text-muted">Primitif Kriptografi</th>
                    <td>{{ $cbom->primitif_kriptografi }}</td>
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
</div>

<div class="mt-4">
    <a href="{{ route('risk_register.create', ['cbom_id' => $cbom->id]) }}" class="btn btn-orange">Daftar Risiko</a>
    <a href="{{ route('entiti.pengurusan_inventori.cbom.index', ['sbom_id' => $cbom->sbom_id]) }}" class="btn btn-secondary">← Kembali ke Senarai CBOM</a>
</div>

@endsection
