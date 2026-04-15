<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Models\RegisterRisk;
use Illuminate\Http\Request;

class PengurusanRisikoController extends Controller
{
    /**
     * Display a listing of all risk registrations pending approval
     */
    public function index(Request $request)
    {
        $query = RegisterRisk::with([
            'risiko',
            'risiko.subKategoriRisiko',
            'risiko.subKategoriRisiko.kategoriRisiko'
        ]);

        // Search by risk name
        if ($request->filled('search')) {
            $query->whereHas('risiko', function ($q) use ($request) {
                $q->where('nama_risiko', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by risk level (tahap)
        if ($request->filled('tahap')) {
            $query->where('tahap_risiko', $request->tahap);
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'menunggu') {
                $query->whereNull('status_persetujuan')
                      ->orWhere('status_persetujuan', '');
            } else {
                $query->where('status_persetujuan', $status);
            }
        }

        // Default: show pending approval
        if (!$request->filled('status')) {
            $query->whereNull('status_persetujuan')
                  ->orWhere('status_persetujuan', '');
        }

        $risks = $query->paginate(10);

        return view('pengurusan.pengurusan_risiko.index', compact('risks'));
    }

    /**
     * Display the specified risk
     */
    public function show($id)
    {
        $risk = RegisterRisk::with([
            'risiko',
            'risiko.subKategoriRisiko',
            'risiko.subKategoriRisiko.kategoriRisiko',
            'puncaRisiko'
        ])->findOrFail($id);

        return view('pengurusan.pengurusan_risiko.show', compact('risk'));
    }

    /**
     * Show the form for reviewing and approving risk
     */
    public function approval($id)
    {
        $risk = RegisterRisk::findOrFail($id);

        return view('pengurusan.pengurusan_risiko.approval', compact('risk'));
    }

    /**
     * Approve or reject a risk registration
     */
    public function approve(Request $request, $id)
    {
        $risk = RegisterRisk::findOrFail($id);

        $validated = $request->validate([
            'status_persetujuan' => 'required|in:diluluskan,ditolak,tertunda',
            'ulasan' => 'nullable|string|max:1000',
        ]);

        $risk->update($validated);

        return redirect()->route('pengurusan.pengurusan_risiko.index')
                       ->with('success', 'Status persetujuan risiko berjaya dikemas kini');
    }

    /**
     * Display risk assessment report for management
     */
    public function laporanPenilaian()
    {
        $risks = RegisterRisk::with([
            'risiko',
            'risiko.subKategoriRisiko',
            'risiko.subKategoriRisiko.kategoriRisiko',
            'puncaRisiko'
        ])->get();

        // Calculate statistics
        $stats = [
            'total' => $risks->count(),
            'tinggi' => $risks->where('tahap_risiko', 'Tinggi')->count(),
            'sederhana' => $risks->where('tahap_risiko', 'Sederhana')->count(),
            'rendah' => $risks->where('tahap_risiko', 'Rendah')->count(),
        ];

        // Chart data
        $chartData = [
            'categories' => $risks->map(function($risk) {
                return $risk->risiko?->subKategoriRisiko?->kategoriRisiko?->nama_kategori ?? 'Lain-lain';
            })->unique()->values(),
            'counts' => [],
        ];

        // Count risks by category
        foreach ($chartData['categories'] as $category) {
            $count = $risks->filter(function($risk) use ($category) {
                return $risk->risiko?->subKategoriRisiko?->kategoriRisiko?->nama_kategori === $category;
            })->count();
            $chartData['counts'][] = $count;
        }

        return view('pengurusan.pengurusan_risiko.laporan_penilaian', compact('risks', 'stats', 'chartData'));
    }
}
