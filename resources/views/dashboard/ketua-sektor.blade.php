@extends('layouts.app-layout')

@section('title', 'Papan Pemuka - Ketua Sektor')

@section('content')
    <div class="dashboard-header d-flex align-items-center justify-content-between">
        <div>
            <h2>Papan Pemuka Ketua Sektor</h2>
            <p>Selamat datang, {{ auth()->user()->name }}. Pantau risiko dalam sektor anda.</p>
        </div>
        <div>
            <span class="badge dashboard-badge bg-success">Ketua Sektor</span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card-box">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Peratusan Entiti Mengikut Tahap Risiko</h5>
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
                    <h5>Risiko Tertinggi Merentas Entiti</h5>
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

    <div class="card-box mt-3">
        <h5>Senarai Tahap Risiko Entiti</h5>
        @if($entitiRisiko->isEmpty())
            <p class="text-muted">Tiada data entiti untuk dipaparkan.</p>
        @else
            <div class="table-responsive">
                <table class="table table-borderless align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nama Entiti</th>
                            <th>Tahap Risiko</th>
                            <th>Risiko Paling Kritikal</th>
                            <th>Tarikh Semakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entitiRisiko as $item)
                            <tr>
                                <td>{{ $item->pemilik_risiko }}</td>
                                <td><span class="badge bg-secondary">{{ $item->tahap_risiko }}</span></td>
                                <td>{{ $item->max_skor }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->last_review)->format('d/m/Y') }}</td>
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
                        label: 'Bilangan Entri',
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
