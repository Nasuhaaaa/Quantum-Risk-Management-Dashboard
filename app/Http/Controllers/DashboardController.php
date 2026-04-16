<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\RegisterRisk;
use App\Models\User;
use App\Models\Agensi;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            \Log::info('DashboardController::index called');

            $user = Auth::user();
            \Log::info('User authenticated', ['user_id' => $user?->id ?? 'null']);

            $jenisPengguna = $user->jenisPengguna?->jenis_pengguna;
            $currentRole = $user->role_type ?? $jenisPengguna ?? 'Unknown';
            $userAgensiId = $user->agensi_id;

            \Log::info('User role', ['role' => $currentRole, 'jenis_pengguna' => $jenisPengguna]);

            // Define sectors
            $sectors = [
            'Sektor Teknologi',
            'Sektor Operasi',
            'Sektor Kewangan',
            'Sektor Perundangan',
            'Sektor Keselamatan',
            'Sektor Perhubungan',
            'Sektor Latihan',
            'Sektor Infrastruktur',
            'Sektor Aset',
            'Sektor Polisi',
            'Sektor Perancangan',
        ];

        // Build base query with role-based filtering
        $riskQuery = RegisterRisk::query();

        if ($currentRole === 'entiti') {
            // Entiti hanya lihat risiko agensi mereka sendiri
            $riskQuery->where('pemilik_risiko', $user->agensi?->nama_agensi ?? $user->ID_Agensi);
        } elseif ($currentRole === 'ketua_sektor') {
            // Ketua Sektor lihat risiko dari semua agensi dalam sektor mereka
            $userSektor = $user->agensi?->sektor;
            if ($userSektor) {
                $agenciIds = Agensi::where('sektor_id', $userSektor->id)->pluck('nama_agensi')->toArray();
                $riskQuery->whereIn('pemilik_risiko', $agenciIds);
            }
        }
        // Pengurusan and Admin dapat view all (no filter)

        $totalRisiko = (clone $riskQuery)->count();
        $totalAset = (clone $riskQuery)->select('pemilik_risiko')->distinct()->count();

        $riskLevels = (clone $riskQuery)
            ->select('tahap_risiko', DB::raw('count(*) as total'))
            ->groupBy('tahap_risiko')
            ->orderByDesc('total')
            ->get();

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
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get risk levels per entity with their highest risk status
        $entitiRisiko = (clone $riskQuery)
            ->select('pemilik_risiko', 'tahap_risiko', DB::raw('avg(skor_risiko) as purata_skor'), DB::raw('max(skor_risiko) as max_skor'), DB::raw('max(created_at) as last_review'))
            ->groupBy('pemilik_risiko', 'tahap_risiko')
            ->orderByDesc('purata_skor')
            ->take(5)
            ->get();

        // Get high-level risk status for Entiti (highest risk level from their entries)
        $entitiHighestRiskLevel = (clone $riskQuery)
            ->select('tahap_risiko', DB::raw('count(*) as total'))
            ->groupBy('tahap_risiko')
            ->orderByDesc('total')
            ->first();

        // For Pengurusan: Get sector-wise risk data
        $sectorRiskData = [];
        $sectors = [
            'Sektor Teknologi',
            'Sektor Operasi',
            'Sektor Kewangan',
            'Sektor Perundangan',
            'Sektor Keselamatan',
            'Sektor Perhubungan',
            'Sektor Latihan',
            'Sektor Infrastruktur',
            'Sektor Aset',
            'Sektor Polisi',
            'Sektor Perancangan',
        ];

        if ($currentRole === 'pengurusan' || $currentRole === 'admin') {
            foreach ($sectors as $sector) {
                // Get distinct agencies in this sector (by name pattern matching)
                $agenciInSector = Agensi::whereRaw("LOWER(nama_agensi) LIKE LOWER(?)", ['%' . strtolower($sector) . '%'])
                    ->pluck('nama_agensi')
                    ->toArray();

                // Get highest risk level for agensi in this sector
                if (!empty($agenciInSector)) {
                    $sectorRisk = RegisterRisk::whereIn('pemilik_risiko', $agenciInSector)
                        ->select('tahap_risiko', DB::raw('count(*) as total'))
                        ->groupBy('tahap_risiko')
                        ->orderByDesc('total')
                        ->first();
                    $sectorRiskData[$sector] = $sectorRisk?->tahap_risiko ?? 'Tiada Data';
                } else {
                    $sectorRiskData[$sector] = 'Tiada Data';
                }
            }
        }

        // For admin dashboard only
        $userCounts = User::with('jenisPengguna')
            ->get()
            ->groupBy(function ($u) {
                return $u->jenisPengguna?->jenis_pengguna ?? 'Unknown';
            })
            ->map(function ($group) {
                return (object) ['jenis_pengguna' => $group[0]->jenisPengguna?->jenis_pengguna ?? 'Unknown', 'total' => count($group)];
            })
            ->values();

        $totalUsers = User::count();
        $latestUsers = User::with('jenisPengguna')->orderBy('created_at', 'desc')->take(5)->get();

        // Get the entity name for the dashboard header
        $entitiName = $user->agensi?->nama_agensi ?? 'Entiti Tidak Diketahui';

        return view('dashboard.entiti', compact(
            'currentRole',
            'totalRisiko',
            'totalAset',
            'riskLevels',
            'topRisks',
            'topAttention',
            'latestRisks',
            'entitiRisiko',
            'entitiHighestRiskLevel',
            'sectorRiskData',
            'userCounts',
            'totalUsers',
            'latestUsers',
            'sectors',
            'entitiName' // Pass the entity name to the view
        ));
        } catch (\Exception $e) {
            \Log::error('DashboardController error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
