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
<div class="card-box mb-4">
    <h5>Taburan Risiko Mengikut Agensi</h5>
    <canvas id="riskByEntityChart" width="400" height="200"></canvas>
</div>

<!-- Risk Distribution by Level -->
<div class="card-box mb-4">
    <h5>Taburan Risiko Mengikut Tahap</h5>
    <canvas id="riskLevelChart" width="400" height="200"></canvas>
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
    // Risk by Entity Chart
    const riskByEntityCtx = document.getElementById('riskByEntityChart').getContext('2d');
    new Chart(riskByEntityCtx, {
        type: 'bar',
        data: {
            labels: @json($chartData['entities'] ?? []),
            datasets: [{
                label: 'Bilangan Risiko',
                data: @json($chartData['entityCounts'] ?? []),
                backgroundColor: '#ff8c00',
                borderColor: '#ff6b00',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
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
            maintainAspectRatio: true,
        }
    });
</script>

@endsection
