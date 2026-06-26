    <div class="dashboard-header d-flex align-items-center justify-content-between">
        <div>
            <h2>Papan Pemuka Ketua Sektor</h2>
            <p>Selamat datang, {{ $displayName }}. Pantau risiko dalam {{ $userSectorName }}.</p>
        </div>
        <div>
            <span class="badge dashboard-badge bg-success">Ketua Sektor</span>
        </div>
    </div>

    <div class="row g-4 mb-3">
        <div class="col-lg-3">
            <div class="card-box">
                <h6>Jumlah Risiko</h6>
                <p class="fs-2 fw-bold">{{ number_format($totalRisiko) }}</p>
                <p class="text-muted mb-0">Semua risiko dalam sektor anda.</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card-box">
                <h6>Entiti Dipantau</h6>
                <p class="fs-2 fw-bold">{{ number_format($entitiRisiko->pluck('pemilik_risiko')->unique()->count()) }}</p>
                <p class="text-muted mb-0">Entiti yang mempunyai penilaian risiko.</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card-box">
                <h6>Risiko Tinggi</h6>
                <p class="fs-2 fw-bold">{{ number_format($jumlahRisikoTinggi) }}</p>
                <p class="text-muted mb-0">Entri kritikal dalam sektor.</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card-box">
                <h6>Risiko Rendah</h6>
                <p class="fs-2 fw-bold">{{ number_format($jumlahRisikoRendah) }}</p>
                <p class="text-muted mb-0">Entri yang terkawal.</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card-box chart-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Peratusan Entiti Mengikut Tahap Risiko</h5>
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
                    <h5>Risiko Tertinggi Merentas Entiti</h5>
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
                        label: 'Bilangan Entri',
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
