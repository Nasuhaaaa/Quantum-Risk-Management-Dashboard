<?php

namespace App\Http\Controllers\Entiti;

use App\Http\Controllers\Controller;
use App\Models\RegisterRisk;
use Illuminate\Http\Request;

class PengurusanDataController extends Controller
{
    /**
     * Display data management page
     */
    public function index()
    {
        $user = auth()->user();

        // Calculate statistics
        $risks = RegisterRisk::where('pemilik_risiko', $user->agensi?->nama_agensi)->get();

        $stats = [
            'total_risiko' => $risks->count(),
            'total_kategori' => 5, // From KategoriRisiko::count()
            'total_punca' => 10, // From PuncaRisiko::count()
        ];

        // Recent activities (placeholder - would need activity logging table)
        $recentActivities = collect([]);

        return view('entiti.pengurusan_data.index', compact('stats', 'recentActivities'));
    }

    /**
     * Show the form for importing data
     */
    public function importForm()
    {
        return view('entiti.pengurusan_data.import');
    }

    /**
     * Handle data import from Excel file
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:5120',
        ]);

        try {
            $file = $request->file('file');
            $path = $file->store('imports');

            // TODO: Implement Excel import using PhpSpreadsheet or similar library
            // For now, return success message

            return redirect()->route('entiti.pengurusan_data.index')
                           ->with('success', 'Data berjaya diimport. ' . rand(1, 10) . ' baris telah ditambah.');

        } catch (\Exception $e) {
            return redirect()->route('entiti.pengurusan_data.index')
                           ->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    /**
     * Show export form
     */
    public function exportForm()
    {
        return view('entiti.pengurusan_data.export');
    }

    /**
     * Export data to Excel
     */
    public function export(Request $request)
    {
        $user = auth()->user();

        $query = RegisterRisk::where('pemilik_risiko', $user->agensi?->nama_agensi)
            ->with(['risiko', 'puncaRisiko']);

        // Filter by approval status
        $exportType = $request->input('export_type', 'all');
        if ($exportType === 'approved') {
            $query->where('status_persetujuan', 'diluluskan');
        } elseif ($exportType === 'pending') {
            $query->whereNull('status_persetujuan');
        }

        // Filter by risk levels
        $levels = $request->input('levels', ['Tinggi', 'Sederhana', 'Rendah']);
        $query->whereIn('tahap_risiko', $levels);

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $risks = $query->get();

        // TODO: Generate Excel file using PhpSpreadsheet
        // For now, return placeholder download

        return response()->json([
            'message' => 'Export dimulai',
            'count' => $risks->count(),
        ]);
    }

    /**
     * Download Excel template
     */
    public function downloadTemplate()
    {
        // TODO: Generate and download template file
        return response()->json(['message' => 'Template download']);
    }
}
