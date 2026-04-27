<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\RegisterRisk;
use App\Models\User;
use App\Models\Agensi;
use App\Models\Sektor;

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
            $displayName = $user?->username ?? 'Pengguna';

            \Log::info('User role', ['role' => $currentRole, 'jenis_pengguna' => $jenisPengguna]);

            // Get sectors from database
            $sectors = Sektor::pluck('nama_sektor')->toArray();

        // Build base query with role-based filtering
        $riskQuery = RegisterRisk::query();

        if ($currentRole === 'entiti') {
            // Entiti hanya lihat risiko agensi mereka sendiri through cbom -> sbom -> inventori -> agensi_id
            $riskQuery->whereHas('cbom.sbom.inventori', function($q) use ($user) {
                $q->where('agensi_id', $user->agensi_id);
            });
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

        // Get risks for tahap calculations
        $allRisks = (clone $riskQuery)->with('tahapRisiko')->get();

        // Dynamically count all tahap_risiko levels
        $riskCountsByLevel = $allRisks->groupBy(fn($r) => $r->tahapRisiko?->tahap_risiko ?? 'Unknown')->map(fn($items) => $items->count());
        $jumlahRisikoTinggi = $riskCountsByLevel->get('Tinggi', 0);
        $jumlahRisikoSederhana = $riskCountsByLevel->get('Sederhana', 0);
        $jumlahRisikoRendah = $riskCountsByLevel->get('Rendah', 0);
        $jumlahRisikoSangatTinggi = $riskCountsByLevel->get('Sangat Tinggi', 0);
        $jumlahRisikoSangatRendah = $riskCountsByLevel->get('Sangat Rendah', 0);

        // Group risk levels by tahapRisiko relationship
        $riskLevels = $allRisks
            ->groupBy(fn($r) => $r->tahapRisiko?->tahap_risiko ?? 'Unknown')
            ->map(fn($items) => (object)['tahap_risiko' => $items[0]->tahapRisiko?->tahap_risiko ?? 'Unknown', 'total' => $items->count()])
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
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get risk levels per entity with their highest risk status
        $entitiRisikoDirect = (clone $riskQuery)
            ->select('pemilik_risiko', 'tahap_risiko_id', DB::raw('avg(skor_risiko) as purata_skor'), DB::raw('max(skor_risiko) as max_skor'), DB::raw('max(created_at) as last_review'))
            ->with('tahapRisiko')
            ->groupBy('pemilik_risiko', 'tahap_risiko_id')
            ->orderByDesc('purata_skor')
            ->take(10)
            ->get();

        // Map to add tahap_risiko property from relationship
        $entitiRisiko = $entitiRisikoDirect->map(function($item) {
            $item->tahap_risiko = $item->tahapRisiko?->tahap_risiko ?? 'Unknown';
            return $item;
        })->take(5);

        // Get high-level risk status for Entiti (highest risk level from their entries)
        $entitiHighestRisksRaw = (clone $riskQuery)
            ->with('tahapRisiko')
            ->orderByDesc('skor_risiko')
            ->first();

        $entitiHighestRiskLevel = $entitiHighestRisksRaw
            ? (object)['tahap_risiko' => $entitiHighestRisksRaw->tahapRisiko?->tahap_risiko ?? 'Unknown', 'total' => 1]
            : null;

        // For Pengurusan: Get sector-wise risk data
        $sectorRiskData = [];

        if ($currentRole === 'pengurusan' || $currentRole === 'admin') {
            foreach ($sectors as $sector) {
                // Get distinct agencies in this sector by sektor_id
                $sektorId = Sektor::where('nama_sektor', $sector)->first()?->id;

                if ($sektorId) {
                    $agenciInSector = Agensi::where('sektor_id', $sektorId)
                        ->pluck('nama_agensi')
                        ->toArray();

                    // Get highest risk level for agensi in this sector
                    if (!empty($agenciInSector)) {
                        $sectorRisksData = RegisterRisk::whereIn('pemilik_risiko', $agenciInSector)
                            ->with('tahapRisiko')
                            ->orderByDesc('skor_risiko')
                            ->first();
                        $sectorRiskData[$sector] = $sectorRisksData?->tahapRisiko?->tahap_risiko ?? 'Tiada Data';
                    } else {
                        $sectorRiskData[$sector] = 'Tiada Data';
                    }
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
        $userSectorName = $user->agensi?->sektor?->nama_sektor ?? 'Sektor Tidak Diketahui';

        return view('dashboard', compact(
            'currentRole',
            'displayName',
            'totalRisiko',
            'totalAset',
            'jumlahRisikoTinggi',
            'jumlahRisikoSederhana',
            'jumlahRisikoRendah',
            'jumlahRisikoSangatTinggi',
            'jumlahRisikoSangatRendah',
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
            'entitiName',
            'userSectorName'
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
