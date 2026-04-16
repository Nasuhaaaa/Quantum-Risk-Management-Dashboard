    <div class="dashboard-header d-flex align-items-center justify-content-between">
        <div>
            <h2>Papan Pemuka Pengurusan</h2>
            <p>Selamat datang, {{ $displayName }}. Semak gambaran risiko merentas semua sektor.</p>
        </div>
        <div>
            <span class="badge dashboard-badge bg-warning">Pengurusan</span>
        </div>
    </div>

    <div class="row g-4 mb-3">
        <div class="col-lg-3">
            <div class="card-box">
                <h6>Jumlah Risiko</h6>
                <p class="fs-2 fw-bold">{{ number_format($totalRisiko) }}</p>
                <p class="text-muted mb-0">Semua rekod risiko dalam pemantauan.</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card-box">
                <h6>Entiti Dinilai</h6>
                <p class="fs-2 fw-bold">{{ number_format($totalAset) }}</p>
                <p class="text-muted mb-0">Entiti atau pemilik risiko unik.</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card-box">
                <h6>Risiko Tinggi</h6>
                <p class="fs-2 fw-bold">{{ number_format($jumlahRisikoTinggi) }}</p>
                <p class="text-muted mb-0">Entri yang perlu tindakan segera.</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card-box">
                <h6>Risiko Sederhana</h6>
                <p class="fs-2 fw-bold">{{ number_format($jumlahRisikoSederhana) }}</p>
                <p class="text-muted mb-0">Entri yang masih perlu dipantau.</p>
            </div>
        </div>
    </div>

    <div class="card-box">
        <h5 class="mb-4">Senarai Tahap Risiko Setiap Sektor</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Sektor</th>
                        <th>Tahap Risiko</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sectors as $sector)
                        <tr>
                            <td>
                                <strong>{{ $sector }}</strong>
                            </td>
                            <td>
                                @php
                                    $riskLevel = $sectorRiskData[$sector] ?? 'Tiada Data';
                                @endphp
                                @if($riskLevel === 'Tiada Data')
                                    <span class="badge bg-secondary">Tiada Data</span>
                                @else
                                    <span class="badge bg-danger">{{ $riskLevel }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted py-4">Tiada sektor untuk dipaparkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
