<?php

namespace App\Http\Controllers\Entiti;

use App\Http\Controllers\Controller;
use App\Models\RegisterRisk;
use App\Models\KategoriRisiko;
use App\Models\SubKategoriRisiko;
use App\Models\Risiko;
use App\Models\KategoriPuncaRisiko;
use App\Models\PuncaRisiko;
use Illuminate\Http\Request;

class PengurusanRisikoController extends Controller
{
    /**
     * Display a listing of registered risks with filters
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // Build query for risks owned by user's entity
        $query = RegisterRisk::query()
            ->where('pemilik_risiko', $user->agensi?->nama_agensi)
            ->with(['risiko', 'risiko.subKategoriRisiko', 'risiko.subKategoriRisiko.kategoriRisiko']);

        // Search by risk name
        if ($request->filled('search')) {
            $query->whereHas('risiko', function ($q) use ($request) {
                $q->where('nama_risiko', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by risk level
        if ($request->filled('tahap')) {
            $query->where('tahap_risiko', $request->tahap);
        }

        // Filter by approval status
        if ($request->filled('status')) {
            if ($request->status === 'menunggu') {
                $query->whereNull('status_persetujuan');
            } else {
                $query->where('status_persetujuan', $request->status);
            }
        }

        $risks = $query->paginate(10);

        return view('entiti.pengurusan_risiko.index', compact('risks'));
    }

    /**
     * Show the form for creating a new risk registration
     */
    public function create()
    {
        $kategoriRisiko = KategoriRisiko::all();
        $subKategoriRisiko = SubKategoriRisiko::all();
        $risiko = Risiko::all();
        $kategoriPuncaRisiko = KategoriPuncaRisiko::all();
        $puncaRisiko = PuncaRisiko::all();

        return view('entiti.pengurusan_risiko.create', compact('kategoriRisiko', 'subKategoriRisiko', 'risiko', 'kategoriPuncaRisiko', 'puncaRisiko'));
    }

    /**
     * Store a newly created risk registration in database
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nama_risiko' => 'required|string|max:255',
            'kategori_risiko_id' => 'required|exists:kategori_risiko,id',
            'sub_kategori_risiko_id' => 'required|exists:sub_kategori_risiko,id',
            'pemilik_risiko' => 'required|string|max:255',
            'tahap_risiko' => 'required|in:Tinggi,Sederhana,Rendah',
            'kemungkinan' => 'required|integer|min:1|max:5',
            'kesan' => 'required|integer|min:1|max:5',
            'penerangan' => 'nullable|string',
        ]);

        // Set agensi_id from authenticated user
        $validated['ID_Agensi'] = $user->ID_Agensi;
        $validated['status_persetujuan'] = null; // Default to pending approval

        RegisterRisk::create($validated);

        return redirect()->route('entiti.pengurusan_risiko.index')
                       ->with('success', 'Risiko berjaya didaftarkan');
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

        // Check authorization
        if ($risk->pemilik_risiko !== auth()->user()->agensi?->nama_agensi) {
            abort(403, 'Unauthorized access');
        }

        return view('entiti.pengurusan_risiko.show', compact('risk'));
    }

    /**
     * Show the form for editing the risk
     */
    public function edit($id)
    {
        $risk = RegisterRisk::findOrFail($id);

        // Check authorization
        if ($risk->pemilik_risiko !== auth()->user()->agensi?->nama_agensi) {
            abort(403, 'Unauthorized access');
        }

        $kategori = KategoriRisiko::all();
        $subKategori = SubKategoriRisiko::all();

        return view('entiti.pengurusan_risiko.edit', compact('risk', 'kategori', 'subKategori'));
    }

    /**
     * Update the specified risk
     */
    public function update(Request $request, $id)
    {
        $risk = RegisterRisk::findOrFail($id);

        // Check authorization
        if ($risk->pemilik_risiko !== auth()->user()->agensi?->nama_agensi) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'nama_risiko' => 'required|string|max:255',
            'kategori_risiko_id' => 'required|exists:kategori_risiko,id',
            'sub_kategori_risiko_id' => 'required|exists:sub_kategori_risiko,id',
            'pemilik_risiko' => 'required|string|max:255',
            'tahap_risiko' => 'required|in:Tinggi,Sederhana,Rendah',
            'kemungkinan' => 'required|integer|min:1|max:5',
            'kesan' => 'required|integer|min:1|max:5',
            'penerangan' => 'nullable|string',
        ]);

        $risk->update($validated);

        return redirect()->route('entiti.pengurusan_risiko.index')
                       ->with('success', 'Risiko berjaya dikemas kini');
    }

    /**
     * Remove the specified risk
     */
    public function destroy($id)
    {
        $risk = RegisterRisk::findOrFail($id);

        // Check authorization
        if ($risk->pemilik_risiko !== auth()->user()->agensi?->nama_agensi) {
            abort(403, 'Unauthorized access');
        }

        $risk->delete();

        return redirect()->route('entiti.pengurusan_risiko.index')
                       ->with('success', 'Risiko berjaya dihapus');
    }

    /**
     * Display risk assessment report with statistics
     */
    public function laporanPenilaian()
    {
        $user = auth()->user();

        $risks = RegisterRisk::where('pemilik_risiko', $user->agensi?->nama_agensi)
            ->with(['risiko', 'risiko.subKategoriRisiko', 'puncaRisiko'])
            ->get();

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

        return view('entiti.pengurusan_risiko.laporan_penilaian', compact('risks', 'stats', 'chartData'));
    }
}
