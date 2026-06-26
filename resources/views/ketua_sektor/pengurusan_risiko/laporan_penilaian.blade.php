@extends('layouts.app-layout')

@section('title', 'Laporan Penilaian Risiko Sektor')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Laporan Penilaian Risiko Sektor</h2>
        <p>Analisis Risiko Seluruh Sektor</p>
    </div>
    <div>
        <button class="btn btn-sm btn-secondary" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak
        </button>
    </div>
</div>

<a href="{{ route('sektor.pengurusan_risiko.index') }}" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

<!-- Summary Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card-box text-center">
            <h3 class="text-orange">{{ $stats['total'] ?? 0 }}</h3>
            <p class="text-muted">Jumlah Risiko</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-box text-center">
            <h3 class="text-danger">{{ $stats['tinggi'] ?? 0 }}</h3>
            <p class="text-muted">Risiko Tinggi</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-box text-center">
            <h3 class="text-warning">{{ $stats['sederhana'] ?? 0 }}</h3>
            <p class="text-muted">Risiko Sederhana</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-box text-center">
            <h3 class="text-info">{{ $stats['rendah'] ?? 0 }}</h3>
            <p class="text-muted">Risiko Rendah</p>
        </div>
    </div>
</div>

<!-- Risk by Entity -->
<div class="card-box mb-4 chart-card">
    <h5>Taburan Risiko Mengikut Agensi</h5>
    <div class="chart-frame">
        <canvas id="riskByEntityChart"></canvas>
    </div>
</div>

<!-- Risk Distribution by Level -->
<div class="card-box mb-4 chart-card">
    <h5>Taburan Risiko Mengikut Tahap</h5>
    <div class="chart-frame chart-frame-compact">
        <canvas id="riskLevelChart"></canvas>
    </div>
</div>

<!-- Risk Details by Entity -->
<div class="card-box mb-4">
    <h5>Risiko Mengikut Agensi</h5>

    @forelse($risksByEntity as $agensi => $risks)
    <div class="mb-4">
        <h6 class="text-orange">{{ $agensi }} ({{ count($risks) }} risiko)</h6>
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Risiko</th>
                        <th>Tahap</th>
                        <th>Pemilik</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($risks as $risk)
                    <tr>
                        <td>{{ $risk->nama_risiko }}</td>
                        <td>
                            @if($risk->tahap_risiko === 'Tinggi')
                                <span class="badge bg-danger">Tinggi</span>
                            @elseif($risk->tahap_risiko === 'Sederhana')
                                <span class="badge bg-warning">Sederhana</span>
                            @else
                                <span class="badge bg-info">Rendah</span>
                            @endif
                        </td>
                        <td>{{ $risk->pemilik_risiko }}</td>
                        <td>
                            @if($risk->status_persetujuan === 'diluluskan')
                                <span class="badge bg-success">Diluluskan</span>
                            @else
                                <span class="badge bg-secondary">Menunggu</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @empty
    <p class="text-muted text-center">Tiada risiko untuk dilaporkan</p>
    @endforelse
</div>

<!-- Mitigation Plans -->
<div class="card-box">
    <h5>Rancangan Mitigasi Sektor</h5>

    <div class="table-responsive">
        <table class="table table-sm table-hover">
            <thead class="table-light">
                <tr>
                    <th>Agensi</th>
                    <th>Risiko</th>
                    <th>Punca Risiko</th>
                    <th>Rancangan Mitigasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($risks as $risk)
                    @forelse($risk->puncaRisiko as $punca)
                    <tr>
                        <td>{{ $risk->agensi?->nama_agensi ?? '-' }}</td>
                        <td><strong>{{ $risk->nama_risiko }}</strong></td>
                        <td>{{ $punca->nama_punca }}</td>
                        <td>{{ $punca->pelan_mitigasi ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Tiada punca risiko</td>
                    </tr>
                    @endforelse
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Tiada data mitigasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = '"Segoe UI", system-ui, sans-serif';
    Chart.defaults.color = '#687789';

    const chartGridColor = 'rgba(104, 119, 137, 0.16)';
    const chartTooltip = {
        backgroundColor: '#111827',
        titleColor: '#ffffff',
        bodyColor: '#e5e7eb',
        padding: 12,
        cornerRadius: 8,
        displayColors: false
    };

    // Risk by Entity Chart
    const riskByEntityCtx = document.getElementById('riskByEntityChart').getContext('2d');
    const entityGradient = riskByEntityCtx.createLinearGradient(0, 0, 0, 300);
    entityGradient.addColorStop(0, '#147c8b');
    entityGradient.addColorStop(1, '#8bc6cf');

    new Chart(riskByEntityCtx, {
        type: 'bar',
        data: {
            labels: @json($chartData['entities'] ?? []),
            datasets: [{
                label: 'Bilangan Risiko',
                data: @json($chartData['entityCounts'] ?? []),
                backgroundColor: entityGradient,
                borderColor: '#0f6672',
                borderWidth: 1,
                borderRadius: 8,
                borderSkipped: false,
                barThickness: 34,
                maxBarThickness: 42
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: chartTooltip
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        maxRotation: 0,
                        minRotation: 0,
                        autoSkip: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: chartGridColor,
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            }
        }
    });

    // Risk Level Chart
    const riskLevelCtx = document.getElementById('riskLevelChart').getContext('2d');
    new Chart(riskLevelCtx, {
        type: 'doughnut',
        data: {
            labels: ['Tinggi', 'Sederhana', 'Rendah'],
            datasets: [{
                data: [{{ $stats['tinggi'] ?? 0 }}, {{ $stats['sederhana'] ?? 0 }}, {{ $stats['rendah'] ?? 0 }}],
                backgroundColor: ['#dc3545', '#ffc107', '#17a2b8'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        boxWidth: 8,
                        padding: 18
                    }
                },
                tooltip: chartTooltip
            }
        }
    });
</script>

@endsection
