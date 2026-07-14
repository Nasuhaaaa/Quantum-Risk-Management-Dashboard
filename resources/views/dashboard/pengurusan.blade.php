@extends('layouts.app-layout')

@section('title', 'Laporan Penilaian Risiko Migrasi PQC')

@section('content')
    @php
        $levelTone = [
            'Sangat Tinggi' => ['class' => 'bg-danger', 'soft' => 'bg-danger-subtle text-danger', 'bar' => '#b91c1c'],
            'Tinggi' => ['class' => 'bg-warning text-dark', 'soft' => 'bg-warning-subtle text-warning', 'bar' => '#c27803'],
            'Sederhana' => ['class' => 'bg-info text-dark', 'soft' => 'bg-info-subtle text-info', 'bar' => '#0f766e'],
            'Rendah' => ['class' => 'bg-success', 'soft' => 'bg-success-subtle text-success', 'bar' => '#15803d'],
            'Sangat Rendah' => ['class' => 'bg-secondary', 'soft' => 'bg-secondary-subtle text-secondary', 'bar' => '#475569'],
            'Tiada Data' => ['class' => 'bg-light text-dark', 'soft' => 'bg-light text-dark', 'bar' => '#94a3b8'],
        ];

        $priorityTone = [
            'Immediate' => 'bg-danger',
            'High' => 'bg-warning text-dark',
            'Medium' => 'bg-info text-dark',
            'Low' => 'bg-secondary',
        ];

        $readinessTone = match ($overallReadiness) {
            'Tinggi' => 'bg-success',
            'Sederhana' => 'bg-warning text-dark',
            default => 'bg-danger',
        };

        $panelTone = [
            'Good' => 'bg-success-subtle text-success',
            'Partial' => 'bg-warning-subtle text-warning',
            'Weak' => 'bg-danger-subtle text-danger',
            'Missing' => 'bg-secondary-subtle text-secondary',
        ];

        $maxDistribution = max($riskDistribution->max('count') ?: 1, 1);
        $maxExposure = max($algorithmExposure->max('count') ?: 1, 1);
        $maxFunction = max($functionRiskAnalysis->max('count') ?: 1, 1);
        $maxRootCause = max($rootCauseSummary->max('count') ?: 1, 1);
        $maxCritical = max($criticalSystems->max('risk_score') ?: 1, 1);
    @endphp

    <div class="pqc-report">
        <div class="report-hero mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <div class="mini-label report-muted-strong mb-2">National PQC Migration Risk Report</div>
                    <h2 class="mb-2">Papan Pemuka Pengurusan</h2>
                    <p class="mb-0 report-muted-strong">Selamat datang, {{ $displayName }}. Laporan ini memberi gambaran ringkas untuk menentukan sektor yang perlu bermigrasi dahulu, mengenal pasti kelemahan lazim, dan mengagihkan sumber secara berfokus.</p>
                </div>
                <div class="text-end">
                    <span class="badge {{ $readinessTone }} report-badge mb-2">Overall Readiness: {{ $overallReadiness }}</span>
                    <div>
                        <span class="badge bg-light text-dark report-badge">Pentadbir Bahagian</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="kpi-card p-3">
                    <div class="mini-label mb-1">Bilangan Sektor</div>
                    <div class="kpi-value">{{ number_format($sectorCount) }}</div>
                    <div class="report-note mt-2">Bilangan sektor yang terlibat.</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="kpi-card p-3">
                    <div class="mini-label mb-1">Bilangan Entiti</div>
                    <div class="kpi-value">{{ number_format($totalEntities) }}</div>
                    <div class="report-note mt-2">Bilangan entiti/agensi yang terlibat.</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="kpi-card p-3">
                    <div class="mini-label mb-1">Bilangan Aset</div>
                    <div class="kpi-value">{{ number_format($totalCryptographicAssets) }}</div>
                    <div class="report-note mt-2">Bilangan aset (inventori) yang telah didaftarkan.</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="kpi-card p-3">
                    <div class="mini-label mb-1">Daftar Risiko</div>
                    <div class="kpi-value">{{ number_format($totalRiskRegisters) }}</div>
                    <div class="report-note mt-2">Bilangan risiko yang telah didaftarkan dalam sistem.</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="kpi-card p-3">
                    <div class="mini-label mb-1">Risiko Tinggi & Kritikal</div>
                    <div class="kpi-value">{{ number_format($highCriticalRisks) }}</div>
                    <div class="report-note mt-2">Bilangan risiko pada tahap Tinggi dan Sangat Tinggi.</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="kpi-card p-3">
                    <div class="mini-label mb-1">Skor Purata IKPK</div>
                    <div class="kpi-value">{{ number_format($averageIkpkScore, 1) }} <span class="fs-6 fw-semibold text-muted">/ 5</span></div>
                    <div class="report-note mt-2">Skor purata normalisasi berdasarkan tahap risiko semasa.</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="kpi-card p-3">
                    <div class="mini-label mb-1">Tahap Risiko Semasa</div>
                    <div class="kpi-value fs-3">{{ $overallReadiness }}</div>
                    <div class="report-note mt-2">Tahap kesiapsiagaan semasa untuk migrasi PQC.</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="kpi-card p-3">
                    <div class="mini-label mb-1">Entiti Dinilai</div>
                    <div class="kpi-value">{{ number_format($totalAset) }}</div>
                    <div class="report-note mt-2">Entiti atau pemilik risiko unik yang muncul dalam daftar risiko.</div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-7">
                <div class="section-card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="section-title">Overall Risk Distribution</div>
                            <div class="text-muted small">Pecahan tahap risiko semasa untuk semua rekod yang dinilai.</div>
                        </div>
                        <span class="badge bg-light text-dark">{{ number_format($totalRisiko) }} risk records</span>
                    </div>

                    @forelse($riskDistribution as $item)
                        @php $tone = $levelTone[$item->label] ?? $levelTone['Tiada Data']; @endphp
                        @php
                            $barClass = match ($item->label) {
                                'Sangat Tinggi' => 'bar-fill--level-sangat-tinggi',
                                'Tinggi' => 'bar-fill--level-tinggi',
                                'Sederhana' => 'bar-fill--level-sederhana',
                                'Rendah' => 'bar-fill--level-rendah',
                                'Sangat Rendah' => 'bar-fill--level-sangat-rendah',
                                default => 'bar-fill--level-tiada-data',
                            };
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="fw-semibold">{{ $item->label }}</div>
                                <div class="text-muted small">{{ $item->percentage }}%</div>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill {{ $barClass }} bar-fill--risk" style="width: {{ $item->percentage }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Tiada data risiko untuk dipaparkan.</p>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-5">
                <div class="section-card p-4 h-100">
                    <div class="section-title mb-1">Migration Readiness Snapshot</div>
                    <div class="text-muted small mb-3">Ringkasan pantas untuk mesyuarat pengurusan.</div>

                    <div class="row g-3">
                        @foreach($migrationPriority as $priority)
                            <div class="col-6">
                                <div class="kpi-card p-3">
                                    <div class="mini-label mb-1">{{ $priority->label }}</div>
                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                        <div class="fw-bold fs-4">{{ number_format($priority->count) }}</div>
                                        <span class="badge {{ $priorityTone[$priority->label] ?? 'bg-secondary' }}">{{ $priority->criteria }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">High-level decision state</span>
                            <span class="badge {{ $readinessTone }}">{{ $overallReadiness }}</span>
                        </div>
                        <p class="report-note mb-0">Fokus utama adalah sistem dengan RSA/ECC, data kritikal, dan kawalan kriptografi yang masih lemah.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="section-card p-4 h-100">
                    <div class="section-title mb-1">1. Risk Profile by Sector</div>
                    <div class="text-muted small mb-3">Ranking yang terus menunjukkan sektor mana perlu diberi perhatian terlebih dahulu.</div>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="report-col-60">#</th>
                                    <th>Sector</th>
                                    <th class="report-col-130">Overall Risk</th>
                                    <th class="report-col-140">Priority</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sectorRanking as $index => $item)
                                    @php $tone = $levelTone[$item->risk_level] ?? $levelTone['Tiada Data']; @endphp
                                    <tr>
                                        <td class="fw-bold">{{ $index + 1 }}</td>
                                        <td>{{ $item->sector }}</td>
                                        <td>
                                            <span class="badge {{ $tone['soft'] }}">{{ $item->risk_level }}</span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $priorityTone[$item->priority] ?? 'bg-secondary' }}">{{ $item->priority }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Tiada data sektor untuk dipaparkan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="section-card p-4 h-100">
                    <div class="section-title mb-1">2. Cryptographic Inventory Summary</div>
                    <div class="text-muted small mb-3">Ringkasan komponen kriptografi yang paling banyak muncul dalam SBOM/CBOM.</div>

                    @forelse($algorithmExposure as $item)
                        @php
                            $width = round(($item->count / $maxExposure) * 100);
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="fw-semibold">{{ $item->label }}</div>
                                <div class="text-muted small">{{ number_format($item->count) }}</div>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill bar-fill--inventory" style="width: {{ $width }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Tiada inventori kriptografi untuk dipaparkan.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="section-card p-4 h-100">
                    <div class="section-title mb-1">3. Algorithm Quantum Exposure</div>
                    <div class="text-muted small mb-3">Komponen yang paling terdedah kepada migrasi PQC berdasarkan penggunaan algoritma semasa.</div>

                    @forelse($algorithmExposure as $item)
                        @php
                            $riskLabel = in_array($item->label, ['RSA-2048', 'ECC P-256'], true) ? 'Very High' : 'Low';
                            $toneClass = $riskLabel === 'Very High' ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success';
                            $width = round(($item->count / $maxExposure) * 100);
                        @endphp
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div class="fw-semibold">{{ $item->label }}</div>
                                    <span class="badge {{ $toneClass }}">{{ $riskLabel }}</span>
                                </div>
                                <div class="bar-track">
                                    <div class="bar-fill {{ $riskLabel === 'Very High' ? 'bar-fill--exposure-very-high' : 'bar-fill--exposure-low' }}" style="width: {{ $width }}%;"></div>
                                </div>
                            </div>
                            <div class="text-end report-min-width-72">
                                <div class="fw-bold">{{ number_format($item->count) }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Tiada data exposure untuk dipaparkan.</p>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-6">
                <div class="section-card p-4 h-100">
                    <div class="section-title mb-1">4. Function Risk Analysis</div>
                    <div class="text-muted small mb-3">Mengapa fungsi tertentu berisiko lebih tinggi dalam migrasi kripto.</div>

                    @forelse($functionRiskAnalysis as $item)
                        @php
                            $width = round(($item->count / $maxFunction) * 100);
                            $functionTone = $item->risk === 'Very High' ? 'bg-danger-subtle text-danger' : ($item->risk === 'Medium' ? 'bg-warning-subtle text-warning' : 'bg-secondary-subtle text-secondary');
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="fw-semibold">{{ $item->label }}</div>
                                <span class="badge {{ $functionTone }}">{{ $item->risk }}</span>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill bar-fill--function" style="width: {{ $width }}%;"></div>
                            </div>
                            <div class="text-muted small mt-1">{{ number_format($item->count) }} record matched</div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Tiada data fungsi untuk dipaparkan.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-7">
                <div class="section-card p-4 h-100">
                    <div class="section-title mb-1">5. Critical Systems</div>
                    <div class="text-muted small mb-3">Top sistem yang perlu diprioritikan dalam rancangan migrasi.</div>

                    @forelse($criticalSystems as $system)
                        @php
                            $width = round(($system->risk_score / $maxCritical) * 100);
                            $tone = $levelTone[$system->criticality] ?? $levelTone['Tiada Data'];
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div>
                                    <div class="fw-semibold">{{ $system->system }}</div>
                                    <div class="text-muted small">{{ $system->sector }}</div>
                                </div>
                                <div class="text-end">
                                    <span class="badge {{ $tone['soft'] }}">{{ $system->criticality }}</span>
                                </div>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill bar-fill--critical" style="width: {{ $width }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Tiada sistem kritikal untuk dipaparkan.</p>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-5">
                <div class="section-card p-4 h-100">
                    <div class="section-title mb-1">6. Risk Register Summary</div>
                    <div class="text-muted small mb-3">Kelas isu yang paling kerap muncul dalam daftar risiko.</div>

                    @forelse($rootCauseSummary as $item)
                        @php $width = round(($item->count / $maxRootCause) * 100); @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="fw-semibold">{{ $item->label }}</div>
                                <div class="text-muted small">{{ number_format($item->count) }}</div>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill bar-fill--cause" style="width: {{ $width }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Tiada ringkasan kategori tersedia.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-5">
                <div class="section-card p-4 h-100">
                    <div class="section-title mb-1">7. Common Root Causes</div>
                    <div class="text-muted small mb-3">Faktor penyumbang yang paling kerap muncul dalam risiko semasa.</div>

                    @forelse($rootCauseSummary as $item)
                        @php $width = round(($item->count / $maxRootCause) * 100); @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="fw-semibold">{{ $item->label }}</div>
                                <div class="text-muted small">{{ $item->count }}%</div>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill" style="width: {{ $width }}%; background: linear-gradient(90deg, #12324a 0%, #0f766e 100%);"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Tiada data punca risiko untuk dipaparkan.</p>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-7">
                <div class="section-card p-4 h-100">
                    <div class="section-title mb-1">8. Existing Controls vs Gaps</div>
                    <div class="text-muted small mb-3">Gambaran ringkas kawalan semasa dan jurang yang perlu ditutup.</div>

                    <div class="row g-3">
                        @foreach($controlGapSummary as $item)
                            <div class="col-md-6">
                                <div class="kpi-card p-3 h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="fw-semibold">{{ $item->label }}</div>
                                        <span class="badge {{ $panelTone[$item->status] ?? 'bg-secondary-subtle text-secondary' }}">{{ $item->status }}</span>
                                    </div>
                                    <div class="report-note mb-0">Status ini membantu menilai bidang yang memerlukan tindakan segera.</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 d-flex flex-wrap gap-2">
                        @foreach($controlGapSummary as $item)
                            <span class="control-pill {{ $panelTone[$item->status] ?? 'bg-secondary-subtle text-secondary' }}">
                                {{ $item->label }}: {{ $item->status }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-7">
                <div class="section-card p-4 h-100">
                    <div class="section-title mb-1">9. Overall Heatmap</div>
                    <div class="text-muted small mb-3">Bilangan risiko bagi gabungan likelihood dan impact.</div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th></th>
                                    @foreach(['Low', 'Med', 'High'] as $impact)
                                        <th>{{ $impact }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(['Low', 'Med', 'High'] as $likelihood)
                                    <tr>
                                        <th class="table-light">{{ $likelihood }}</th>
                                        @foreach(['Low', 'Med', 'High'] as $impact)
                                            @php
                                                $cellValue = data_get($heatmapMatrix, $likelihood . '.' . $impact, 0);
                                                $cellClass = $cellValue >= 15 ? 'matrix-high' : ($cellValue >= 6 ? 'matrix-med' : 'matrix-low');
                                            @endphp
                                            <td class="matrix-cell {{ $cellClass }}">{{ $cellValue }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="section-card p-4 h-100">
                    <div class="section-title mb-1">10. Migration Priority</div>
                    <div class="text-muted small mb-3">Tahap peralihan yang perlu difokuskan oleh pengurusan.</div>

                    @foreach($migrationPriority as $item)
                        @php
                            $tone = $priorityTone[$item->label] ?? 'bg-secondary';
                        @endphp
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="badge {{ $tone }} timeline-badge">{{ $item->label }}</span>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $item->criteria }}</div>
                                <div class="text-muted small">{{ number_format($item->count) }} systems / records</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="section-card p-4">
            <div class="section-title mb-1">11. Recommended Actions</div>
            <div class="text-muted small mb-3">Urutan tindakan berasaskan horizon masa untuk pelaksanaan PQC.</div>

            @foreach($recommendedActions as $action)
                <div class="timeline-step">
                    <span class="badge bg-dark timeline-badge">{{ $action['timeframe'] }}</span>
                    <div>
                        <div class="fw-semibold">{{ $action['recommendation'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
