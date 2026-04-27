@extends('layouts.app-layout')

@section('title', 'Senarai CBOM')

@section('content')
<div class="dashboard-header">
    <div>
        <h2>Senarai CBOM</h2>
        <p>Pilih CBOM untuk meneruskan proses daftar risiko.</p>
    </div>
</div>

<div class="card-box mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5>Senarai CBOM</h5>
        <a href="{{ route('entiti.pengurusan_inventori.cbom.create', ['sbom_id' => $sbom_id]) }}" class="btn btn-primary btn-sm">+ Tambah CBOM</a>
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
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cboms as $index => $cbom)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $cbom->primitif_kriptografi }}</td>
                            <td>{{ $cbom->algoritma_kriptografi }}</td>
                            <td>{{ $cbom->panjang_kunci }}</td>
                            <td>{{ $cbom->tujuan_penggunaan }}</td>
                            <td>{{ $cbom->library_modules }}</td>
                            <td>{{ $cbom->kategori_data }}</td>
                            <td>{{ $cbom->sokongan_crypto_agility }}</td>
                            <td>
                                <a href="{{ route('entiti.pengurusan_inventori.cbom.show', ['cbom_id' => $cbom->id]) }}" class="btn btn-sm btn-info">Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
