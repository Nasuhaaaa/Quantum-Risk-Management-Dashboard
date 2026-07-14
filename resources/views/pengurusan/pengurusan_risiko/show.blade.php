@extends('layouts.app-layout')

@section('title', 'Lihat Risiko')

@section('content')

@php
$levelValue = $risk->tahapRisiko?->tahap_risiko ?? $risk->tahap_risiko ?? '-';
$statusValue = $risk->status_kelulusan ?? 'Dalam semakan';
$assetName = $risk->cbom?->sbom?->inventori?->nama_aset ?? 'Tidak dikenal pasti';
$ownerName = $risk->pemilik_risiko ?? 'Tiada maklumat';
$registeredAt = $risk->created_at?->translatedFormat('d F Y • H:i') ?? '-';
$algorithm = $risk->cbom?->algoritma_kriptografi ?? '-';
$keyLength = !empty($risk->cbom?->panjang_kunci) ? $risk->cbom->panjang_kunci . '-bit' : '-';
$component = $risk->cbom?->sbom?->komponen_versi ?? '-';
$subComponent = $risk->cbom?->sbom?->sub_komponen ?? '-';
$dataCategory = $risk->cbom?->kategori_data ?? '-';
$likelihood = $risk->kebarangkalian?->skala ?? $risk->kemungkinan ?? '-';
$impact = $risk->impak?->skala ?? $risk->impak ?? '-';
$riskScore = $risk->skor_risiko ?? '-';

$levelClass = match (strtolower($levelValue)) {
    'tinggi' => 'danger',
    'sederhana' => 'warning',
    'rendah' => 'success',
    default => 'secondary',
};

$statusClass = match (strtolower($statusValue)) {
    'diluluskan' => 'success',
    'ditolak' => 'danger',
    'dalam semakan', 'pending', 'menunggu' => 'warning',
    default => 'info',
};

$descriptionText = trim($risk->kawalan_sedia_ada ?? '');
if ($descriptionText === '') {
    $descriptionText = 'Risiko ini berkaitan dengan aset ' . $assetName . ' dan memerlukan pemantauan serta penambahbaikan kawalan untuk mengurangkan potensi kelemahan yang berulang.';
}
@endphp

<div class="mb-4">
    <a href="{{ route('pengurusan.pengurusan_risiko.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
</div>

<div class="card-box shadow-sm border-0 mb-4 p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-start">
        <div>
            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge bg-{{ $levelClass }} px-3 py-2">{{ $levelValue }}</span>
                <span class="badge bg-{{ $statusClass }} px-3 py-2">{{ $statusValue }}</span>
            </div>
            <h2 class="fw-bold mb-2">{{ $risk->risiko?->nama_risiko ?? 'Maklumat Risiko' }}</h2>
            <p class="text-muted mb-0">{{ $assetName }} · {{ $ownerName }} · {{ $registeredAt }}</p>
        </div>

        @if($hasApprovalColumns)
        <div>
            <span class="badge bg-{{ $statusClass }} px-3 py-2">{{ $statusValue }}</span>
        </div>
        @endif
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-box shadow-sm border-0 mb-4 p-4">
            <h4 class="fw-bold mb-4">Maklumat Umum</h4>
            <div class="row gy-3">
                <div class="col-md-6">
                    <div>
                        <div class="text-muted small fw-semibold mb-1">Nama Risiko</div>
                        <div class="fw-semibold fs-5">{{ $risk->risiko?->nama_risiko ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <div class="text-muted small fw-semibold mb-1">Aset</div>
                        <div class="fw-semibold fs-5">{{ $assetName }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <div class="text-muted small fw-semibold mb-1">Pemilik Risiko</div>
                        <div class="fw-semibold fs-5">{{ $ownerName }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <div class="text-muted small fw-semibold mb-1">Tarikh Daftar</div>
                        <div class="fw-semibold fs-5">{{ $registeredAt }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-box shadow-sm border-0 mb-4 p-4">
            <h4 class="fw-bold mb-4">Maklumat Teknikal</h4>
            <div class="row gy-3">
                <div class="col-md-6">
                    <div>
                        <div class="text-muted small fw-semibold mb-1">Algoritma</div>
                        <div class="fw-semibold">{{ $algorithm }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <div class="text-muted small fw-semibold mb-1">Primitif</div>
                        <div class="fw-semibold">{{ $risk->cbom?->primitif_kriptografi ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <div class="text-muted small fw-semibold mb-1">Panjang Kunci</div>
                        <div class="fw-semibold">{{ $keyLength }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <div class="text-muted small fw-semibold mb-1">Komponen</div>
                        <div class="fw-semibold">{{ $component }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <div class="text-muted small fw-semibold mb-1">Sub-Komponen</div>
                        <div class="fw-semibold">{{ $subComponent }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <div class="text-muted small fw-semibold mb-1">Kategori Data</div>
                        <div class="fw-semibold">{{ $dataCategory }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-box shadow-sm border-0 mb-4 p-4">
            <h4 class="fw-bold mb-4">Penilaian Risiko</h4>
            <div class="row gy-3">
                <div class="col-md-6">
                    <div>
                        <div class="text-muted small fw-semibold mb-1">Kebarangkalian</div>
                        <div class="fw-semibold">{{ $likelihood }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <div class="text-muted small fw-semibold mb-1">Impak</div>
                        <div class="fw-semibold">{{ $impact }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <div class="text-muted small fw-semibold mb-1">Skor Risiko</div>
                        <div class="fw-semibold">{{ $riskScore }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <div class="text-muted small fw-semibold mb-1">Keutamaan</div>
                        <div class="fw-semibold">{{ $levelValue }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-box shadow-sm border-0 mb-4 p-4">
            <h4 class="fw-bold mb-4">Penerangan Risiko</h4>
            <p class="mb-0 text-dark">{{ $descriptionText }}</p>
        </div>

        <div class="card-box shadow-sm border-0 p-4">
            <h4 class="fw-bold mb-4">Mitigasi</h4>
            <div class="mb-3">
                <div class="text-muted small fw-semibold mb-1">Kawalan Sedia Ada</div>
                <div class="text-dark">{{ $risk->kawalan_sedia_ada ?? '-' }}</div>
            </div>
            <div>
                <div class="text-muted small fw-semibold mb-1">Cadangan Mitigasi</div>
                <div class="text-dark">{{ $risk->pelan_mitigasi ?? 'Sila sediakan pelan mitigasi yang lebih terperinci untuk risiko ini.' }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-box shadow-sm border-0 p-4">
            <h4 class="fw-bold mb-4">Semakan & Kelulusan</h4>
            <div class="mb-3 pb-3 border-bottom">
                <div class="text-muted small fw-semibold mb-1">Status</div>
                <div class="fw-semibold fs-5">{{ $statusValue }}</div>
            </div>
            <div class="mb-3 pb-3 border-bottom">
                <div class="text-muted small fw-semibold mb-1">Diluluskan Oleh</div>
                <div class="fw-semibold">{{ $risk->diluluskan_oleh ?? '-' }}</div>
            </div>
            <div class="mb-3 pb-3 border-bottom">
                <div class="text-muted small fw-semibold mb-1">Tarikh Semakan</div>
                <div class="fw-semibold">{{ $risk->diluluskan_pada ? (is_string($risk->diluluskan_pada) ? \Carbon\Carbon::parse($risk->diluluskan_pada)->format('d/m/Y H:i') : $risk->diluluskan_pada->format('d/m/Y H:i')) : '-' }}</div>
            </div>
            <div>
                <div class="text-muted small fw-semibold mb-1">Catatan</div>
                <div class="text-dark">{{ $risk->catatan ?? 'Tiada catatan semakan setakat ini.' }}</div>
            </div>
        </div>
    </div>
</div>

@if($hasApprovalColumns)
<div class="card-box shadow-sm border-0 p-4 mt-4">
    <h4 class="fw-bold mb-4">Keputusan Kelulusan</h4>
    <form method="POST" action="{{ route('pengurusan.pengurusan_risiko.approve', $risk->id) }}" id="approvalForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="status_kelulusan" id="status_kelulusan" value="">

        <div class="mb-3">
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-success" id="approveButton">Lulus</button>
                <button type="button" class="btn btn-outline-danger" id="rejectButton">Tolak</button>
            </div>
        </div>

        <div class="mb-3" id="catatanGroup" style="display: none;">
            <label for="catatan" class="form-label fw-semibold">Catatan</label>
            <textarea name="catatan" id="catatan" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-sm" id="approvalSubmit" disabled>Simpan Keputusan</button>
    </form>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const approveButton = document.getElementById('approveButton');
        const rejectButton = document.getElementById('rejectButton');
        const statusInput = document.getElementById('status_kelulusan');
        const catatanGroup = document.getElementById('catatanGroup');
        const catatanInput = document.getElementById('catatan');
        const approvalSubmit = document.getElementById('approvalSubmit');

        if (!approveButton || !rejectButton || !statusInput || !catatanInput || !approvalSubmit) {
            return;
        }

        approveButton.addEventListener('click', function () {
            statusInput.value = 'Diluluskan';
            catatanGroup.style.display = 'none';
            catatanInput.required = false;
            approvalSubmit.disabled = false;
            approveButton.classList.add('btn-success');
            approveButton.classList.remove('btn-outline-success');
            rejectButton.classList.add('btn-outline-danger');
            rejectButton.classList.remove('btn-danger');
        });

        rejectButton.addEventListener('click', function () {
            statusInput.value = 'Ditolak';
            catatanGroup.style.display = 'block';
            catatanInput.required = true;
            approvalSubmit.disabled = false;
            rejectButton.classList.add('btn-danger');
            rejectButton.classList.remove('btn-outline-danger');
            approveButton.classList.add('btn-outline-success');
            approveButton.classList.remove('btn-success');
        });
    });
</script>

@endsection
