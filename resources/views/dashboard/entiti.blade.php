@extends('layouts.app-layout')

@section('title', 'Papan Pemuka - Entiti')

@section('content')
    <div class="dashboard-header d-flex align-items-center justify-content-between">
        <div>
            <h2>Papan Pemuka Entiti (Agensi)</h2>
            <p>Selamat datang, {{ auth()->user()->name }}. Uruskan dan pantau risiko dalam agensi anda.</p>
        </div>
        <div>
            <span class="badge dashboard-badge bg-info">Entiti</span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card-box stat-card">
                <h6>Jumlah Risiko Didaftarkan</h6>
                <p class="fs-2 fw-bold">{{ number_format($totalRisiko) }}</p>
                <p class="text-muted mb-0">Rekod risiko dalam agensi anda.</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card-box stat-card">
                <h6>Status Risiko</h6>
                <p class="fs-2 fw-bold">{{ $entitiHighestRiskLevel?->tahap_risiko ?? 'Tiada' }}</p>
                <p class="text-muted mb-0">Tahap risiko tertinggi yang dikesan.</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card-box stat-card">
                <h6>Bilangan Aset</h6>
                <p class="fs-2 fw-bold">{{ number_format($totalAset) }}</p>
                <p class="text-muted mb-0">Aset yang telah melalui penilaian risiko.</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card-box stat-card">
                <h6>Tahap Risiko</h6>
                <p class="fs-2 fw-bold">{{ $riskLevels->count() }}</p>
                <p class="text-muted mb-0">Bilangan kategori tahap risiko.</p>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-3">
        <div class="col-lg-6">
            <div class="card-box">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Pecahan Penarafan Risiko</h5>
                    <span class="text-secondary">Donut chart</span>
                </div>
                @if($riskLevels->isEmpty())
                    <p class="text-muted">Tiada data tahap risiko.</p>
                @else
                    <canvas id="riskLevelChart" height="300"></canvas>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card-box">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>5 Risiko Tertinggi dalam Entiti</h5>
                    <span class="text-secondary">Graf bar</span>
                </div>
                @if($topRisks->isEmpty())
                    <p class="text-muted">Tiada data risiko tertinggi.</p>
                @else
                    <canvas id="topRiskChart" height="300"></canvas>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4 mt-3">
        <div class="col-lg-6">
            <div class="card-box">
                <h5>Paparan Ringkas - 3 Aset Memerlukan Perhatian</h5>
                @if($topAttention->isEmpty())
                    <p class="text-muted">Tiada aset yang memerlukan perhatian segera.</p>
                @else
                    <div class="list-group">
                        @foreach($topAttention as $item)
                            <div class="list-group-item border-0 p-3 mb-2 shadow-sm rounded-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong>{{ optional($item->risiko)->nama_risiko ?? 'Risiko Tidak Diketahui' }}</strong>
                                        <p class="mb-1 text-muted">Aset: {{ $item->pemilik_risiko }}</p>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-danger">Skor {{ $item->skor_risiko }}</span>
                                        <p class="mb-0 text-muted">{{ $item->tahap_risiko }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card-box">
                <h5>Peratusan Aset yang Dinilai</h5>
                @if($totalAset > 0)
                    <div class="text-center mb-3">
                        <h2 class="display-4 fw-bold text-primary">100%</h2>
                        <p class="text-muted">{{ $totalAset }} daripada {{ $totalAset }} aset telah dinilai</p>
                    </div>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                    </div>
                @else
                    <p class="text-muted">Tiada aset untuk dinilai.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="card-box mt-3">
        <h5>Entri Risiko Terkini</h5>
        @if($latestRisks->isEmpty())
            <p class="text-muted">Tiada entri risiko terkini.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Risiko</th>
                            <th>Aset / Pemilik</th>
                            <th>Skor Risiko</th>
                            <th>Tahap Risiko</th>
                            <th>Tarikh</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestRisks as $item)
                            <tr>
                                <td>{{ optional($item->risiko)->nama_risiko ?? 'Tidak Diketahui' }}</td>
                                <td>{{ $item->pemilik_risiko }}</td>
                                <td>{{ $item->skor_risiko }}</td>
                                <td>{{ $item->tahap_risiko }}</td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td><a href="#" class="btn btn-sm btn-grey">Semak</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const riskLevelData = @json($riskLevels->pluck('total'));
        const riskLevelLabels = @json($riskLevels->pluck('tahap_risiko'));
        const topRiskData = @json($topRisks->map(fn($item) => $item->total));
        const topRiskLabels = @json($topRisks->map(fn($item) => optional($item->risiko)->nama_risiko ?? 'Tidak Diketahui'));

        if (document.getElementById('riskLevelChart')) {
            new Chart(document.getElementById('riskLevelChart'), {
                type: 'doughnut',
                data: {
                    labels: riskLevelLabels,
                    datasets: [{
                        data: riskLevelData,
                        backgroundColor: ['#1f3c88', '#f58220', '#ec4899', '#22c55e', '#6366f1'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }

        if (document.getElementById('topRiskChart')) {
            new Chart(document.getElementById('topRiskChart'), {
                type: 'bar',
                data: {
                    labels: topRiskLabels,
                    datasets: [{
                        label: 'Bilangan Aset Terjejas',
                        data: topRiskData,
                        backgroundColor: '#1f3c88'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
    </script>
@endsection
