<?php

namespace App\Http\Controllers;

use App\Models\Agensi;
use App\Models\CBOM;
use App\Models\RegisterRisk;
use App\Models\Sektor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            Log::info('DashboardController::index called');

            $user = Auth::user();
            Log::info('User authenticated', ['user_id' => $user?->id ?? 'null']);

            $jenisPengguna = $user?->jenisPengguna?->jenis_pengguna;
            $currentRole = $user?->role_type ?? $jenisPengguna ?? 'Unknown';
            $displayName = $user?->username ?? 'Pengguna';

            Log::info('User role', ['role' => $currentRole, 'jenis_pengguna' => $jenisPengguna]);

            $sectors = Sektor::pluck('nama_sektor')->toArray();
            $sectorCount = count($sectors);

            $riskQuery = RegisterRisk::query();

            if ($currentRole === 'entiti') {
                $riskQuery->whereHas('cbom.sbom.inventori', function ($query) use ($user) {
                    $query->where('agensi_id', $user?->agensi_id);
                });
            } elseif ($currentRole === 'ketua_sektor') {
                $userSektor = $user?->agensi?->sektor;

                if ($userSektor) {
                    $agensiIds = Agensi::where('sektor_id', $userSektor->id)->pluck('id');

                    $riskQuery->whereHas('cbom.sbom.inventori', function ($query) use ($agensiIds) {
                        $query->whereIn('agensi_id', $agensiIds);
                    });
                }
            }

            $totalRisiko = (clone $riskQuery)->count();
            $totalAset = (clone $riskQuery)->select('pemilik_risiko')->distinct()->count();

            $allRisks = (clone $riskQuery)->with([
                'tahapRisiko',
                'impak',
                'kebarangkalian',
                'puncaRisiko.kategoriPuncaRisiko',
                'cbom.sbom.inventori.agensi.sektor',
                'risiko',
            ])->get();

            $riskCountsByLevel = $allRisks
                ->groupBy(fn ($risk) => $risk->tahapRisiko?->tahap_risiko ?? 'Unknown')
                ->map(fn ($items) => $items->count());

            $jumlahRisikoTinggi = $riskCountsByLevel->get('Tinggi', 0);
            $jumlahRisikoSederhana = $riskCountsByLevel->get('Sederhana', 0);
            $jumlahRisikoRendah = $riskCountsByLevel->get('Rendah', 0);
            $jumlahRisikoSangatTinggi = $riskCountsByLevel->get('Sangat Tinggi', 0);
            $jumlahRisikoSangatRendah = $riskCountsByLevel->get('Sangat Rendah', 0);

            $highCriticalRisks = $jumlahRisikoTinggi + $jumlahRisikoSangatTinggi;
            $averageRiskScore = round((float) ((clone $riskQuery)->avg('skor_risiko') ?? 0), 1);
            $averageIkpkScore = round($averageRiskScore / 5, 1);
            $overallReadiness = $averageIkpkScore >= 3.5 ? 'Tinggi' : ($averageIkpkScore >= 2.5 ? 'Sederhana' : 'Rendah');

            $totalEntities = Agensi::count();
            $totalCryptographicAssets = CBOM::count();
            $totalRiskRegisters = $allRisks->count();

            $sectorRiskData = [];
            if (in_array($currentRole, ['pengurusan', 'admin'], true)) {
                foreach ($sectors as $sector) {
                    $sectorId = Sektor::where('nama_sektor', $sector)->value('id');

                    if (!$sectorId) {
                        $sectorRiskData[$sector] = 'Tiada Data';
                        continue;
                    }

                    $agensiIdsInSector = Agensi::where('sektor_id', $sectorId)->pluck('id');
                    if ($agensiIdsInSector->isEmpty()) {
                        $sectorRiskData[$sector] = 'Tiada Data';
                        continue;
                    }

                    $sectorRisk = RegisterRisk::whereHas('cbom.sbom.inventori', function ($query) use ($agensiIdsInSector) {
                        $query->whereIn('agensi_id', $agensiIdsInSector);
                    })->with('tahapRisiko')->orderByDesc('skor_risiko')->first();

                    $sectorRiskData[$sector] = $sectorRisk?->tahapRisiko?->tahap_risiko ?? 'Tiada Data';
                }
            }

            $riskDistribution = collect(['Sangat Tinggi', 'Tinggi', 'Sederhana', 'Rendah', 'Sangat Rendah'])->map(function ($level) use ($riskCountsByLevel, $totalRisiko) {
                $count = $riskCountsByLevel->get($level, 0);

                return (object) [
                    'label' => $level,
                    'count' => $count,
                    'percentage' => $totalRisiko > 0 ? round(($count / $totalRisiko) * 100) : 0,
                ];
            });

            $severityRank = [
                'Sangat Tinggi' => 5,
                'Tinggi' => 4,
                'Sederhana' => 3,
                'Rendah' => 2,
                'Sangat Rendah' => 1,
                'Tiada Data' => 0,
            ];

            $sectorRanking = collect($sectors)->map(function ($sector) use ($sectorRiskData, $severityRank) {
                $riskLevel = $sectorRiskData[$sector] ?? 'Tiada Data';
                $riskScore = $severityRank[$riskLevel] ?? 0;

                if ($riskScore >= 5) {
                    $priority = 'Immediate';
                } elseif ($riskScore === 4) {
                    $priority = 'High';
                } elseif ($riskScore === 3) {
                    $priority = 'Medium';
                } else {
                    $priority = 'Low';
                }

                return (object) [
                    'sector' => $sector,
                    'risk_level' => $riskLevel,
                    'risk_score' => $riskScore,
                    'priority' => $priority,
                ];
            })->sortByDesc('risk_score')->values();

            $criticalSystems = $allRisks->groupBy(function ($risk) {
                return $risk->cbom?->sbom?->inventori?->nama_aset ?? 'Tidak Diketahui';
            })->map(function ($systemRisks) {
                $highestRisk = $systemRisks->sortByDesc('skor_risiko')->first();

                return (object) [
                    'system' => $highestRisk?->cbom?->sbom?->inventori?->nama_aset ?? 'Tidak Diketahui',
                    'sector' => $highestRisk?->cbom?->sbom?->inventori?->agensi?->sektor?->nama_sektor ?? 'Tiada Data',
                    'criticality' => $highestRisk?->tahapRisiko?->tahap_risiko ?? 'Tiada Data',
                    'risk_score' => $highestRisk?->skor_risiko ?? 0,
                ];
            })->sortByDesc('risk_score')->take(10)->values();

            $algorithmExposure = collect([
                ['label' => 'RSA-2048', 'pattern' => 'RSA'],
                ['label' => 'ECC P-256', 'pattern' => 'EC'],
                ['label' => 'AES-256', 'pattern' => 'AES'],
                ['label' => 'SHA-256', 'pattern' => 'SHA-256'],
                ['label' => 'TLS Certificates', 'pattern' => 'TLS'],
            ])->map(function ($item) use ($allRisks) {
                $count = 0;

                foreach ($allRisks as $risk) {
                    $text = strtoupper(implode(' | ', [
                        (string) ($risk->cbom?->algoritma_kriptografi ?? ''),
                        (string) ($risk->cbom?->tujuan_penggunaan ?? ''),
                        (string) ($risk->cbom?->library_modules ?? ''),
                        (string) ($risk->cbom?->sbom?->kepakaran_kriptografi ?? ''),
                        (string) ($risk->cbom?->sbom?->komponen_versi ?? ''),
                    ]));

                    if (str_contains($text, $item['pattern'])) {
                        $count++;
                    }
                }

                return (object) [
                    'label' => $item['label'],
                    'count' => $count,
                ];
            });

            $functionRiskAnalysis = collect([
                ['label' => 'Key Exchange', 'keywords' => ['ECDH', 'RSA'], 'risk' => 'Very High'],
                ['label' => 'Digital Signature', 'keywords' => ['ECDSA', 'RSA'], 'risk' => 'Very High'],
                ['label' => 'Encryption', 'keywords' => ['AES', 'TLS'], 'risk' => 'Medium'],
                ['label' => 'Hashing', 'keywords' => ['SHA', 'DIGEST'], 'risk' => 'Low'],
            ])->map(function ($item) use ($allRisks) {
                $count = 0;

                foreach ($allRisks as $risk) {
                    $text = strtoupper(implode(' | ', [
                        (string) ($risk->cbom?->algoritma_kriptografi ?? ''),
                        (string) ($risk->cbom?->tujuan_penggunaan ?? ''),
                        (string) ($risk->cbom?->library_modules ?? ''),
                        (string) ($risk->puncaRisiko?->punca_risiko ?? ''),
                    ]));

                    foreach ($item['keywords'] as $keyword) {
                        if (str_contains($text, strtoupper($keyword))) {
                            $count++;
                            break;
                        }
                    }
                }

                return (object) [
                    'label' => $item['label'],
                    'risk' => $item['risk'],
                    'count' => $count,
                ];
            });

            $rootCauseSummary = $allRisks->groupBy(function ($risk) {
                return $risk->puncaRisiko?->kategoriPuncaRisiko?->kategori_punca_risiko ?? 'Lain-lain';
            })->map(function ($items, $label) {
                return (object) [
                    'label' => $label,
                    'count' => $items->count(),
                ];
            })->sortByDesc('count')->take(6)->values();

            $controlGapSummary = [
                (object) ['label' => 'Asset Inventory', 'status' => $totalCryptographicAssets > 0 ? 'Partial' : 'Missing'],
                (object) ['label' => 'Risk Assessment', 'status' => $totalRiskRegisters > 0 ? 'Good' : 'Missing'],
                (object) ['label' => 'PQC Policy', 'status' => 'Missing'],
                (object) ['label' => 'Migration Plan', 'status' => $allRisks->whereNotNull('pelan_mitigasi')->count() > 0 ? 'Partial' : 'Missing'],
                (object) ['label' => 'Crypto Agility', 'status' => $totalCryptographicAssets > 0 ? 'Weak' : 'Missing'],
            ];

            $prioritySummary = [
                'Immediate' => $allRisks->filter(fn ($risk) => in_array($risk->tahapRisiko?->tahap_risiko, ['Tinggi', 'Sangat Tinggi'], true))->count(),
                'High' => $allRisks->filter(fn ($risk) => $risk->tahapRisiko?->tahap_risiko === 'Sederhana')->count(),
                'Medium' => $allRisks->filter(fn ($risk) => $risk->tahapRisiko?->tahap_risiko === 'Rendah')->count(),
                'Low' => $allRisks->filter(fn ($risk) => $risk->tahapRisiko?->tahap_risiko === 'Sangat Rendah')->count(),
            ];

            $migrationPriority = [
                (object) ['label' => 'Immediate', 'criteria' => 'RSA/ECC + Critical System', 'count' => $prioritySummary['Immediate']],
                (object) ['label' => 'High', 'criteria' => 'Critical Data', 'count' => $prioritySummary['High']],
                (object) ['label' => 'Medium', 'criteria' => 'Internal Systems', 'count' => $prioritySummary['Medium']],
                (object) ['label' => 'Low', 'criteria' => 'Non-critical', 'count' => $prioritySummary['Low']],
            ];

            $band = function ($value) {
                return match ($value) {
                    'Sangat Rendah', 'Rendah' => 'Low',
                    'Sederhana' => 'Med',
                    'Tinggi', 'Sangat Tinggi' => 'High',
                    default => 'Med',
                };
            };

            $heatmapMatrix = [
                'Low' => ['Low' => 0, 'Med' => 0, 'High' => 0],
                'Med' => ['Low' => 0, 'Med' => 0, 'High' => 0],
                'High' => ['Low' => 0, 'Med' => 0, 'High' => 0],
            ];

            foreach ($allRisks as $risk) {
                $impact = $band($risk->impak?->tahap ?? null);
                $likelihood = $band($risk->kebarangkalian?->tahap ?? null);

                $heatmapMatrix[$likelihood][$impact]++;
            }

            $recommendedActions = collect([
                ['timeframe' => '0–6 months', 'recommendation' => 'Complete cryptographic inventory'],
                ['timeframe' => '0–6 months', 'recommendation' => 'Identify vulnerable RSA/ECC systems'],
                ['timeframe' => '6–12 months', 'recommendation' => 'Develop PQC migration roadmap'],
                ['timeframe' => '12–24 months', 'recommendation' => 'Begin hybrid PQC deployment'],
                ['timeframe' => 'Continuous', 'recommendation' => 'Annual risk assessment'],
            ]);

            $riskLevels = $allRisks
                ->groupBy(fn ($risk) => $risk->tahapRisiko?->tahap_risiko ?? 'Unknown')
                ->map(fn ($items) => (object) ['tahap_risiko' => $items->first()?->tahapRisiko?->tahap_risiko ?? 'Unknown', 'total' => $items->count()])
                ->values();

            $topRisks = (clone $riskQuery)
                ->with('risiko')
                ->select('risiko_id', DB::raw('count(*) as total'))
                ->groupBy('risiko_id')
                ->orderByDesc('total')
                ->take(5)
                ->get();

            $topAttention = (clone $riskQuery)
                ->with('risiko', 'puncaRisiko')
                ->orderByDesc('skor_risiko')
                ->take(3)
                ->get();

            $latestRisks = (clone $riskQuery)
                ->with('risiko', 'puncaRisiko')
                ->orderByDesc('created_at')
                ->take(5)
                ->get();

            $entitiRisikoDirect = (clone $riskQuery)
                ->select('pemilik_risiko', 'tahap_risiko_id', DB::raw('avg(skor_risiko) as purata_skor'), DB::raw('max(skor_risiko) as max_skor'), DB::raw('max(created_at) as last_review'))
                ->with('tahapRisiko')
                ->groupBy('pemilik_risiko', 'tahap_risiko_id')
                ->orderByDesc('purata_skor')
                ->take(10)
                ->get();

            $entitiRisiko = $entitiRisikoDirect->map(function ($item) {
                $item->tahap_risiko = $item->tahapRisiko?->tahap_risiko ?? 'Unknown';

                return $item;
            })->take(5);

            $entitiHighestRisksRaw = (clone $riskQuery)->with('tahapRisiko')->orderByDesc('skor_risiko')->first();
            $entitiHighestRiskLevel = $entitiHighestRisksRaw
                ? (object) ['tahap_risiko' => $entitiHighestRisksRaw->tahapRisiko?->tahap_risiko ?? 'Unknown', 'total' => 1]
                : null;

            $userCounts = User::with('jenisPengguna')
                ->get()
                ->groupBy(fn ($userRow) => $userRow->jenisPengguna?->jenis_pengguna ?? 'Unknown')
                ->map(function ($group) {
                    return (object) [
                        'jenis_pengguna' => $group->first()?->jenisPengguna?->jenis_pengguna ?? 'Unknown',
                        'total' => $group->count(),
                    ];
                })
                ->values();

            $totalUsers = User::count();
            $latestUsers = User::with('jenisPengguna')->orderByDesc('created_at')->take(5)->get();

            $entitiName = $user?->agensi?->nama_agensi ?? 'Entiti Tidak Diketahui';
            $userSectorName = $user?->agensi?->sektor?->nama_sektor ?? 'Sektor Tidak Diketahui';

            return view('dashboard', compact(
                'currentRole',
                'displayName',
                'sectorCount',
                'totalEntities',
                'totalCryptographicAssets',
                'totalRiskRegisters',
                'totalRisiko',
                'totalAset',
                'jumlahRisikoTinggi',
                'jumlahRisikoSederhana',
                'jumlahRisikoRendah',
                'jumlahRisikoSangatTinggi',
                'jumlahRisikoSangatRendah',
                'highCriticalRisks',
                'averageIkpkScore',
                'overallReadiness',
                'riskDistribution',
                'riskLevels',
                'sectorRanking',
                'topRisks',
                'topAttention',
                'latestRisks',
                'entitiRisiko',
                'entitiHighestRiskLevel',
                'criticalSystems',
                'algorithmExposure',
                'functionRiskAnalysis',
                'rootCauseSummary',
                'controlGapSummary',
                'heatmapMatrix',
                'migrationPriority',
                'recommendedActions',
                'sectorRiskData',
                'userCounts',
                'totalUsers',
                'latestUsers',
                'sectors',
                'entitiName',
                'userSectorName'
            ));
        } catch (\Exception $e) {
            Log::error('DashboardController error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }
}
