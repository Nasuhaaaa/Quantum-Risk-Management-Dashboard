<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Models\RegisterRisk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

class PengurusanRisikoController extends Controller
{
    /**
     * Display a listing of all risk registrations pending approval
     */
    public function index(Request $request)
    {
        $hasApprovalColumns = $this->hasApprovalColumns();
        $isReviewMode = $request->routeIs('pengurusan.pengurusan_risiko.semak_sahkan');

        $query = RegisterRisk::with([
            'cbom.sbom.inventori.agensi',
            'risiko',
            'risiko.subKategoriRisiko',
            'risiko.subKategoriRisiko.kategoriRisiko',
            'tahapRisiko'
        ]);

        // Search by risk name
        if ($request->filled('search')) {
            $query->whereHas('risiko', function ($q) use ($request) {
                $q->where('nama_risiko', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tahap')) {
            $query->whereHas('tahapRisiko', function ($q) use ($request) {
                $q->where('tahap_risiko', $request->tahap);
            });
        }

        // Filter by status
        if ($hasApprovalColumns && $request->filled('status')) {
            $status = $request->status;
            if ($status === 'menunggu') {
                $query->where(function ($q) {
                    $q->whereNull('status_kelulusan')
                        ->orWhere('status_kelulusan', '');
                });
            } else {
                $query->where('status_kelulusan', $status);
            }
        }

        // Review mode defaults to pending approval when the current schema supports it.
        if ($isReviewMode && $hasApprovalColumns && !$request->filled('status')) {
            $query->where(function ($q) {
                $q->whereNull('status_kelulusan')
                    ->orWhere('status_kelulusan', '');
            });
        }

        $allRisks = $query->get();
        $page = max(1, (int) $request->get('page', 1));
        $perPage = 10;
        $currentPageItems = $allRisks->slice(($page - 1) * $perPage, $perPage)->values();

        $risks = new LengthAwarePaginator(
            $currentPageItems,
            $allRisks->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $riskCollection = $allRisks;

        $groupedRisks = $riskCollection->groupBy(function ($risk) {
            $agency = $risk->cbom?->sbom?->inventori?->agensi;
            return $agency?->sektor?->nama_sektor ?? 'Tidak dikategorikan';
        })->map(function ($sectorRisks, $sectorName) {
            $agencies = $sectorRisks->groupBy(function ($risk) {
                $agency = $risk->cbom?->sbom?->inventori?->agensi;
                return $agency?->nama_agensi ?? 'Tidak dikenal pasti';
            })->map(function ($agencyRisks, $agencyName) {
                $agencyRisks = $agencyRisks->map(function ($risk) {
                    $risk->approval_status = $risk->status_kelulusan ?? '';
                    return $risk;
                });

                return [
                    'agency_name' => $agencyName,
                    'risks' => $agencyRisks->values(),
                    'total' => $agencyRisks->count(),
                    'approved' => $agencyRisks->where('status_kelulusan', 'Diluluskan')->count(),
                    'rejected' => $agencyRisks->where('status_kelulusan', 'Ditolak')->count(),
                    'pending' => $agencyRisks->filter(function ($risk) {
                        $status = trim((string) ($risk->status_kelulusan ?? ''));
                        return $status === '' || in_array(strtolower($status), ['dalam semakan', 'menunggu', 'pending'], true);
                    })->count(),
                ];
            })->values();

            return [
                'sector_name' => $sectorName,
                'agencies' => $agencies,
                'total' => $sectorRisks->count(),
            ];
        })->values();

        $summary = [
            'total' => $risks->total(),
            'approved' => $riskCollection->where('status_kelulusan', 'Diluluskan')->count(),
            'rejected' => $riskCollection->where('status_kelulusan', 'Ditolak')->count(),
            'pending' => $riskCollection->filter(function ($risk) {
                $status = trim((string) ($risk->status_kelulusan ?? ''));
                return $status === '' || in_array(strtolower($status), ['dalam semakan', 'menunggu', 'pending'], true);
            })->count(),
        ];

        return view('pengurusan.pengurusan_risiko.index', compact('risks', 'groupedRisks', 'summary', 'hasApprovalColumns', 'isReviewMode'));
    }

    /**
     * Display the specified risk
     */
    public function show($id)
    {
        $hasApprovalColumns = $this->hasApprovalColumns();

        $risk = RegisterRisk::with([
            'cbom.sbom.inventori.agensi',
            'risiko',
            'risiko.subKategoriRisiko',
            'risiko.subKategoriRisiko.kategoriRisiko',
            'puncaRisiko',
            'tahapRisiko',
            'impak',
            'kebarangkalian'
        ])->findOrFail($id);

        return view('pengurusan.pengurusan_risiko.show', compact('risk', 'hasApprovalColumns'));
    }

    /**
     * Show the form for reviewing and approving risk
     */
    public function approval($id)
    {
        if (!$this->hasApprovalColumns()) {
            return redirect()->route('pengurusan.pengurusan_risiko.index')
                ->with('warning', 'Fungsi persetujuan belum tersedia untuk struktur pangkalan data semasa.');
        }

        $risk = RegisterRisk::with(['risiko', 'tahapRisiko'])->findOrFail($id);

        return view('pengurusan.pengurusan_risiko.approval', compact('risk'));
    }

    /**
     * Approve or reject a risk registration
     */
    public function approve(Request $request, $id)
    {
        if (!$this->hasApprovalColumns()) {
            return redirect()->route('pengurusan.pengurusan_risiko.index')
                ->with('warning', 'Fungsi persetujuan belum tersedia untuk struktur pangkalan data semasa.');
        }

        $risk = RegisterRisk::findOrFail($id);

        $validated = $request->validate([
            'status_kelulusan' => 'required|in:Diluluskan,Ditolak',
            'catatan' => 'nullable|string|max:1000',
        ]);

        if ($validated['status_kelulusan'] === 'Ditolak') {
            $request->validate([
                'catatan' => 'required|string|max:1000',
            ]);
        }

        $risk->update([
            'status_kelulusan' => $validated['status_kelulusan'],
            'diluluskan_oleh' => 'Pentadbir Bahagian',
            'diluluskan_pada' => Carbon::now(),
            'catatan' => $request->input('catatan'),
        ]);

        return redirect()->route('pengurusan.pengurusan_risiko.index')
                       ->with('success', 'Keputusan kelulusan risiko berjaya disimpan');
    }

    /**
     * Display risk assessment report for management
     */
    public function laporanPenilaian()
    {
        $risks = RegisterRisk::with([
            'cbom.sbom.inventori.agensi',
            'risiko',
            'risiko.subKategoriRisiko',
            'risiko.subKategoriRisiko.kategoriRisiko',
            'puncaRisiko',
            'tahapRisiko'
        ])->get();

        // Calculate statistics
        $stats = [
            'total' => $risks->count(),
            'tinggi' => $risks->filter(fn($r) => $r->tahapRisiko?->tahap_risiko === 'Tinggi')->count(),
            'sederhana' => $risks->filter(fn($r) => $r->tahapRisiko?->tahap_risiko === 'Sederhana')->count(),
            'rendah' => $risks->filter(fn($r) => $r->tahapRisiko?->tahap_risiko === 'Rendah')->count(),
        ];

        // Chart data
        $chartData = [
            'categories' => $risks->map(function($risk) {
                return $risk->risiko?->subKategoriRisiko?->kategoriRisiko?->kategori_risiko ?? 'Lain-lain';
            })->unique()->values(),
            'counts' => [],
        ];

        // Count risks by category
        foreach ($chartData['categories'] as $category) {
            $count = $risks->filter(function($risk) use ($category) {
                return $risk->risiko?->subKategoriRisiko?->kategoriRisiko?->kategori_risiko === $category;
            })->count();
            $chartData['counts'][] = $count;
        }

        return view('pengurusan.pengurusan_risiko.laporan_penilaian', compact('risks', 'stats', 'chartData'));
    }

    private function hasApprovalColumns(): bool
    {
        return Schema::hasColumn('risk_register', 'status_kelulusan')
            && Schema::hasColumn('risk_register', 'catatan');
    }
}
