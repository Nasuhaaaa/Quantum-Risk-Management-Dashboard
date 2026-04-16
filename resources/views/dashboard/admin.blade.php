    <div class="dashboard-header d-flex align-items-center justify-content-between">
        <div>
            <h2>Papan Pemuka Sistem Admin</h2>
            <p>Selamat datang, {{ $displayName }}. Anda mempunyai akses penuh ke sistem.</p>
        </div>
        <div>
            <span class="badge dashboard-badge bg-primary">Admin</span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card-box">
                <h6>Jumlah Risiko</h6>
                <p class="fs-2 fw-bold">{{ number_format($totalRisiko) }}</p>
                <p class="text-muted mb-0">Semua risiko dalam sistem.</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card-box">
                <h6>Jumlah Aset</h6>
                <p class="fs-2 fw-bold">{{ number_format($totalAset) }}</p>
                <p class="text-muted mb-0">Aset unik yang dinilai.</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card-box">
                <h6>Jumlah Pengguna</h6>
                <p class="fs-2 fw-bold">{{ number_format($totalUsers) }}</p>
                <p class="text-muted mb-0">Pengguna berdaftar.</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card-box">
                <h6>Risiko Tinggi</h6>
                <p class="fs-2 fw-bold">{{ number_format($jumlahRisikoTinggi) }}</p>
                <p class="text-muted mb-0">Entri yang memerlukan perhatian segera.</p>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-3">
        <div class="col-lg-6">
            <div class="card-box">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Pecahan Tahap Risiko</h5>
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
        <h5>Bilangan Pengguna Mengikut Peranan</h5>
        @if($userCounts->isEmpty())
            <p class="text-muted">Tiada pengguna dikesan.</p>
        @else
            <div class="table-responsive">
                <table class="table table-borderless align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Peranan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userCounts as $item)
                            <tr>
                                <td>{{ $item->jenis_pengguna }}</td>
                                <td>{{ $item->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="card-box mt-3">
        <h5>Pengguna Terbaru</h5>
        @if($latestUsers->isEmpty())
            <p class="text-muted">Tiada pengguna terbaru.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Pengguna</th>
                            <th>Peranan</th>
                            <th>Tarikh Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestUsers as $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->jenisPengguna?->jenis_pengguna ?? 'Tidak Diketahui' }}</td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
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
