    <div class="dashboard-header d-flex align-items-center justify-content-between">
        <div>
            <h2>Papan Pemuka Entiti ({{ $entitiName }})</h2>
            <p>Selamat datang, {{ $displayName }}. Uruskan dan pantau risiko dalam agensi anda.</p>
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
                <p class="fs-2 fw-bold">{{ number_format($jumlahRisikoTinggi) }}</p>
                <p class="text-muted mb-0">Bilangan entri pada tahap tinggi.</p>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-3">
        <div class="col-lg-6">
            <div class="card-box chart-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Pecahan Penarafan Risiko</h5>
                </div>
                @if($riskLevels->isEmpty())
                    <p class="text-muted">Tiada data tahap risiko.</p>
                @else
                    <div class="chart-frame chart-frame-dashboard-donut">
                        <canvas id="riskLevelChart"></canvas>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card-box chart-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>5 Risiko Tertinggi dalam Entiti</h5>
                </div>
                @if($topRisks->isEmpty())
                    <p class="text-muted">Tiada data risiko tertinggi.</p>
                @else
                    <div class="chart-frame chart-frame-dashboard-bar">
                        <canvas id="topRiskChart"></canvas>
                    </div>
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
        Chart.defaults.font.family = '"Segoe UI", system-ui, sans-serif';
        Chart.defaults.color = '#687789';

        const dashboardGridColor = 'rgba(104, 119, 137, 0.16)';
        const dashboardTooltip = {
            backgroundColor: '#111827',
            titleColor: '#ffffff',
            bodyColor: '#e5e7eb',
            padding: 12,
            cornerRadius: 8,
            displayColors: false
        };
        const riskLevelData = @json($riskLevels->pluck('total'));
        const riskLevelLabels = @json($riskLevels->pluck('tahap_risiko'));
        const topRiskData = @json($topRisks->map(fn($item) => $item->total));
        const topRiskLabels = @json($topRisks->map(fn($item) => optional($item->risiko)->nama_risiko ?? 'Tidak Diketahui'));
        const compactDashboardLabel = (label, maxLength = 18) => {
            const text = String(label).trim();
            return text.length > maxLength ? `${text.slice(0, maxLength - 1)}…` : text;
        };
        const compactTopRiskLabels = topRiskLabels.map(label => compactDashboardLabel(label));
        const attachAxisLabelTooltip = (chart, fullLabels) => {
            const tooltip = document.createElement('div');
            tooltip.className = 'chart-axis-tooltip';
            document.body.appendChild(tooltip);

            chart.canvas.addEventListener('mousemove', event => {
                const rect = chart.canvas.getBoundingClientRect();
                const x = event.clientX - rect.left;
                const y = event.clientY - rect.top;
                const xScale = chart.scales.x;

                if (!xScale || y < chart.chartArea.bottom || y > xScale.bottom + 8) {
                    tooltip.style.opacity = 0;
                    chart.canvas.style.cursor = '';
                    return;
                }

                let closestIndex = -1;
                let closestDistance = Infinity;

                fullLabels.forEach((label, index) => {
                    const tickX = xScale.getPixelForTick(index);
                    const distance = Math.abs(x - tickX);

                    if (distance < closestDistance) {
                        closestDistance = distance;
                        closestIndex = index;
                    }
                });

                const maxDistance = Math.max(28, xScale.width / Math.max(fullLabels.length, 1) / 2);

                if (closestIndex >= 0 && closestDistance <= maxDistance) {
                    tooltip.textContent = fullLabels[closestIndex];
                    tooltip.style.left = `${event.clientX}px`;
                    tooltip.style.top = `${event.clientY - 12}px`;
                    tooltip.style.opacity = 1;
                    chart.canvas.style.cursor = 'help';
                } else {
                    tooltip.style.opacity = 0;
                    chart.canvas.style.cursor = '';
                }
            });

            chart.canvas.addEventListener('mouseleave', () => {
                tooltip.style.opacity = 0;
                chart.canvas.style.cursor = '';
            });
        };

        if (document.getElementById('riskLevelChart')) {
            new Chart(document.getElementById('riskLevelChart'), {
                type: 'doughnut',
                data: {
                    labels: riskLevelLabels,
                    datasets: [{
                        data: riskLevelData,
                        backgroundColor: ['#c24135', '#d89a00', '#147c8b', '#168a5b', '#284b63'],
                        borderColor: '#ffffff',
                        borderWidth: 3,
                        hoverOffset: 6
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
                        tooltip: dashboardTooltip
                    }
                }
            });
        }

        if (document.getElementById('topRiskChart')) {
            const topRiskCtx = document.getElementById('topRiskChart').getContext('2d');
            const topRiskGradient = topRiskCtx.createLinearGradient(0, 0, 0, 280);
            topRiskGradient.addColorStop(0, '#147c8b');
            topRiskGradient.addColorStop(1, '#8bc6cf');

            const topRiskChart = new Chart(topRiskCtx, {
                type: 'bar',
                data: {
                    labels: compactTopRiskLabels,
                    datasets: [{
                        label: 'Bilangan Aset Terjejas',
                        data: topRiskData,
                        backgroundColor: topRiskGradient,
                        borderColor: '#0f6672',
                        borderWidth: 1,
                        borderRadius: 8,
                        borderSkipped: false,
                        categoryPercentage: 0.72,
                        barPercentage: 0.82,
                        maxBarThickness: 52
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 8,
                            right: 8,
                            bottom: 0,
                            left: 0
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                maxRotation: 0,
                                minRotation: 0,
                                autoSkip: false,
                                font: {
                                    size: 11,
                                    weight: 600
                                },
                                callback: function(value) {
                                    return this.getLabelForValue(value);
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: dashboardGridColor,
                                drawBorder: false
                            },
                            ticks: { precision: 0, stepSize: 1 }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            ...dashboardTooltip,
                            callbacks: {
                                title: items => topRiskLabels[items[0].dataIndex] ?? ''
                            }
                        }
                    }
                }
            });
            attachAxisLabelTooltip(topRiskChart, topRiskLabels);
        }
    </script>
