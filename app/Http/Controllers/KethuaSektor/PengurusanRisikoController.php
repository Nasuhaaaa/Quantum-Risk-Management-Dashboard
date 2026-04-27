<?php

namespace App\Http\Controllers\KethuaSektor;

use App\Http\Controllers\Controller;
use App\Models\RegisterRisk;
use App\Models\Agensi;
use Illuminate\Http\Request;

class PengurusanRisikoController extends Controller
{
    /**
     * Display risk summary for entities in sector
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $sektor = $user->agensi?->sektor;

        // Get all agencies in the sector
        $agentiIds = Agensi::where('sektor_id', $sektor?->id)->pluck('id');

        // Build query for risks from entities in this sector
        $query = RegisterRisk::whereIn('agensi_id', $agentiIds)
            ->with(['risiko', 'risiko.subKategoriRisiko', 'risiko.subKategoriRisiko.kategoriRisiko', 'tahapRisiko']);

        // Search by risk name
        if ($request->filled('search')) {
            $query->whereHas('risiko', function ($q) use ($request) {
                $q->where('nama_risiko', 'like', '%' . $request->search . '%');
            });
        }

        // Note: tahap filtering will be done after collection load
        $risks = $query->paginate(10);

        // Filter by risk level in memory
        if ($request->filled('tahap')) {
            $risks = $risks->filter(function($item) use ($request) {
                return $item->tahapRisiko?->tahap_risiko === $request->tahap;
            });
        }

        $risks = $query->paginate(10);

        return view('ketua_sektor.pengurusan_risiko.index', compact('risks', 'sektor'));
    }

    /**
     * Show risk details
     */
    public function show($id)
    {
        $risk = RegisterRisk::with([
            'risiko',
            'risiko.subKategoriRisiko',
            'risiko.subKategoriRisiko.kategoriRisiko',
            'puncaRisiko'
        ])->findOrFail($id);

        return view('ketua_sektor.pengurusan_risiko.show', compact('risk'));
    }

    /**
     * Display risk assessment report for sector
     */
    public function laporanPenilaian()
    {
        $user = auth()->user();
        $sektor = $user->agensi?->sektor;

        // Get all agencies in the sector
        $agentiIds = Agensi::where('sektor_id', $sektor?->id)->pluck('id');

        // Get all risks from entities in this sector
        $risks = RegisterRisk::whereIn('agensi_id', $agentiIds)
            ->with(['risiko', 'risiko.subKategoriRisiko', 'puncaRisiko', 'tahapRisiko'])
            ->get();

        // Organize risks by entity
        $risksByEntity = $risks->groupBy('pemilik_risiko');

        // Calculate statistics
        $stats = [
            'total' => $risks->count(),
            'tinggi' => $risks->filter(fn($r) => $r->tahapRisiko?->tahap_risiko === 'Tinggi')->count(),
            'sederhana' => $risks->filter(fn($r) => $r->tahapRisiko?->tahap_risiko === 'Sederhana')->count(),
            'rendah' => $risks->filter(fn($r) => $r->tahapRisiko?->tahap_risiko === 'Rendah')->count(),
        ];

        // Chart data
        $chartData = [
            'entities' => Agensi::where('sektor_id', $sektor?->id)->pluck('nama_agensi')->toArray(),
            'entityCounts' => [],
        ];

        // Count risks by entity
        foreach ($chartData['entities'] as $entity) {
            $count = $risks->where('pemilik_risiko', $entity)->count();
            $chartData['entityCounts'][] = $count;
        }

        return view('ketua_sektor.pengurusan_risiko.laporan_penilaian', compact('risks', 'risksByEntity', 'stats', 'chartData', 'sektor'));
    }
}
