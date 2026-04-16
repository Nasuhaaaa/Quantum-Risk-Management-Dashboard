@extends('layouts.app-layout')

@section('title', 'Lihat Inventori')

@section('content')

<!-- Page Header -->
<div class="dashboard-header mb-4">
    <div>
        <h2 class="fw-bold">Lihat Butiran Inventori</h2>
        <p class="text-muted">{{ $inventory->nama_inventori }}</p>
    </div>
</div>


<!-- Inventory Details Section -->
<div class="card-box p-4 mb-4">
    <h5 class="fw-bold mb-3">Butiran Inventori</h5>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th class="text-muted">Nama Inventori</th>
                    <td>{{ $inventory->nama_inventori }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Kategori</th>
                    <td>{{ $inventory->kategori ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Sistem Legasi?</th>
                    <td><span class="badge bg-secondary">{{ $inventory->bilangan ?? 0 }}</span></td>
                </tr>
                <tr>
                    <th class="text-muted">Lokasi</th>
                    <td>{{ $inventory->lokasi ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Status</th>
                    <td>
                        @if($inventory->status === 'aktif')
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Tidak Aktif</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="text-muted">Tarikh Daftar</th>
                    <td>{{ $inventory->created_at?->format('d/m/Y H:i') }}</td>
                </tr>
                @if($inventory->keterangan)
                <tr>
                    <th class="text-muted">Keterangan</th>
                    <td>{{ $inventory->keterangan }}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('entiti.pengurusan_inventori.edit', $inventory->id) }}" class="btn btn-warning">Ubah</a>
        <form method="POST" action="{{ route('entiti.pengurusan_inventori.destroy', $inventory->id) }}" style="display:inline;" onsubmit="return confirm('Adakah anda pasti?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Padam</button>
        </form>
        <a href="{{ route('entiti.pengurusan_inventori.index') }}" class="btn btn-grey">Kembali</a>
    </div>
</div>

<!-- SBOM List Section -->
<div class="card-box p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold">Senarai SBOM</h5>

        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('entiti.pengurusan_inventori.sbom.create', ['inventori_id' => $inventory->id]) }}" class="btn btn-orange w-100" >Tambah SBOM</a>
        </div>
    </div>

    @if($sboms->isEmpty())

        <p class="text-muted">Tiada SBOM yang berkaitan dengan inventori ini.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Komponen Versi</th>
                        <th>Sub Komponen</th>
                        <th>URL</th>
                        <th>Mod Perkhidmatan</th>
                        <th>Language/Framework</th>
                        <th>Modules/Libraries</th>
                        <th>External APIs/Services</th>
                        <th>In-House Vendor</th>
                        <th>Nama Vendor</th>
                        <th>Kepakaran Kriptografi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sboms as $index => $sbom)
                        <tr class="clickable-row" data-href="{{ route('entiti.pengurusan_inventori.sbom.show', $sbom->id) }}" style="cursor: pointer; background-color: #f9f9f9;" onmouseover="this.style.backgroundColor='#e9ecef';" onmouseout="this.style.backgroundColor='#f9f9f9';">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $sbom->komponen_versi }}</td>
                            <td>{{ $sbom->sub_komponen }}</td>
                            <td>{{ $sbom->url }}</td>
                            <td>{{ $sbom->mod_perkhidmatan }}</td>
                            <td>{{ $sbom->language_framework }}</td>
                            <td>{{ $sbom->modules_libraries }}</td>
                            <td>{{ $sbom->external_apis_services }}</td>
                            <td>{{ $sbom->in_house_vendor }}</td>
                            <td>{{ $sbom->nama_vendor }}</td>
                            <td>{{ $sbom->kepakaran_kriptografi }}</td>
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
