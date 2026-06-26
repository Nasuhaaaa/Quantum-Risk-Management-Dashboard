@extends('layouts.app-layout')

@section('title', 'Laporan Penilaian Risiko')

@section('content')

<!-- Page Header -->
<div class="dashboard-header">
    <div>
        <h2>Laporan Penilaian Risiko</h2>
        <p>Analisis keseluruhan daftar risiko mengikut kategori dan tahap risiko</p>
    </div>
    <div>
        <button class="btn btn-sm btn-secondary" onclick="window.print()">Cetak</button>
    </div>
</div>

<a href="{{ route('pengurusan.pengurusan_risiko.index') }}" class="btn btn-sm btn-secondary mb-3">&larr; Kembali</a>

<!-- Summary Stats -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card-box text-center">
            <h3>{{ $stats['total'] ?? 0 }}</h3>
            <p class="text-muted mb-0">Jumlah Risiko</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card-box text-center">
            <h3 class="text-danger">{{ $stats['tinggi'] ?? 0 }}</h3>
            <p class="text-muted mb-0">Risiko Tinggi</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card-box text-center">
            <h3 class="text-warning">{{ $stats['sederhana'] ?? 0 }}</h3>
            <p class="text-muted mb-0">Risiko Sederhana</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card-box text-center">
            <h3 class="text-info">{{ $stats['rendah'] ?? 0 }}</h3>
            <p class="text-muted mb-0">Risiko Rendah</p>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row mb-4">
    <div class="col-lg-7 mb-3">
        <div class="card-box h-100 chart-card">
            <h5>Taburan Risiko Mengikut Kategori</h5>
            <div class="chart-frame">
                <canvas id="riskCategoryChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-5 mb-3">
        <div class="card-box h-100 chart-card">
            <h5>Taburan Risiko Mengikut Tahap</h5>
            <div class="chart-frame chart-frame-compact">
                <canvas id="riskLevelChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Risk Details -->
<div class="card-box mb-4">
    <h5>Senarai Risiko</h5>

    <div class="table-responsive">
        <table class="table table-sm table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Entiti</th>
                    <th>Nama Risiko</th>
                    <th>Kategori</th>
                    <th>Tahap</th>
                    <th>Skor</th>
                    <th>Pemilik</th>
                </tr>
            </thead>
            <tbody>
                @forelse($risks as $risk)
                    @php
                        $tahap = $risk->tahapRisiko?->tahap_risiko ?? $risk->tahap_risiko;
                        $badgeClass = match ($tahap) {
                            'Sangat Tinggi', 'Tinggi' => 'bg-danger',
                            'Sederhana' => 'bg-warning',
                            'Rendah', 'Sangat Rendah' => 'bg-info',
                            default => 'bg-secondary',
                        };
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $risk->cbom?->sbom?->inventori?->agensi?->nama_agensi ?? '-' }}</td>
                        <td>{{ $risk->risiko?->nama_risiko ?? '-' }}</td>
                        <td>{{ $risk->risiko?->subKategoriRisiko?->kategoriRisiko?->kategori_risiko ?? '-' }}</td>
                        <td><span class="badge {{ $badgeClass }}">{{ $tahap ?? '-' }}</span></td>
                        <td>{{ $risk->skor_risiko ?? '-' }}</td>
                        <td>{{ $risk->pemilik_risiko ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Tiada risiko untuk dilaporkan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Mitigation Plans -->
<div class="card-box">
    <h5>Rancangan Mitigasi</h5>

    <div class="table-responsive">
        <table class="table table-sm table-hover">
            <thead class="table-light">
                <tr>
                    <th>Entiti</th>
                    <th>Risiko</th>
                    <th>Punca Risiko</th>
                    <th>Rancangan Mitigasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($risks as $risk)
                    <tr>
                        <td>{{ $risk->cbom?->sbom?->inventori?->agensi?->nama_agensi ?? '-' }}</td>
                        <td>{{ $risk->risiko?->nama_risiko ?? '-' }}</td>
                        <td>{{ $risk->puncaRisiko?->punca_risiko ?? '-' }}</td>
                        <td>{{ $risk->pelan_mitigasi ?? $risk->puncaRisiko?->pelan_mitigasi ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Tiada data mitigasi</td>
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

    const categoryCtx = document.getElementById('riskCategoryChart').getContext('2d');
    const categoryGradient = categoryCtx.createLinearGradient(0, 0, 0, 280);
    categoryGradient.addColorStop(0, '#147c8b');
    categoryGradient.addColorStop(1, '#8bc6cf');

    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: @json($chartData['categories'] ?? []),
            datasets: [{
                label: 'Bilangan Risiko',
                data: @json($chartData['counts'] ?? []),
                backgroundColor: categoryGradient,
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

    const levelCtx = document.getElementById('riskLevelChart').getContext('2d');
    new Chart(levelCtx, {
        type: 'doughnut',
        data: {
            labels: ['Tinggi', 'Sederhana', 'Rendah'],
            datasets: [{
                data: [{{ $stats['tinggi'] ?? 0 }}, {{ $stats['sederhana'] ?? 0 }}, {{ $stats['rendah'] ?? 0 }}],
                backgroundColor: ['#c24135', '#d89a00', '#147c8b'],
                borderColor: '#ffffff',
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
