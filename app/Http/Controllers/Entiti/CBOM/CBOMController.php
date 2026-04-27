<?php

namespace App\Http\Controllers\Entiti\CBOM;

use App\Http\Controllers\Controller;
use App\Models\CBOM;
use App\Models\SBOM;
use Illuminate\Http\Request;

class CBOMController extends Controller
{
    /**
     * Display a listing of CBOMs for the selected SBOM.
     */
    public function index($sbom_id)
    {
        // Fetch CBOMs related to the selected SBOM
        $cboms = CBOM::where('sbom_id', $sbom_id)->get();

        // Pass data to the view
        return view('entiti.pengurusan_inventori.cbom.index', compact('cboms', 'sbom_id'));
    }

    /**
     * Display the specified CBOM.
     */
    public function show($cbom_id)
    {
        // Debugging: Log the received cbom_id
        \Log::info('Received cbom_id: ' . $cbom_id);

        // Fetch the CBOM details
        $cbom = CBOM::findOrFail($cbom_id);

        // Pass data to the view
        return view('entiti.pengurusan_inventori.cbom.show', compact('cbom'));
    }

    /**
     * Show the form for creating a new CBOM.
     */
    public function create($sbom_id)
    {
        // Fetch SBOM to ensure it exists and pass for context
        $sbom = SBOM::findOrFail($sbom_id);

        return view('entiti.pengurusan_inventori.cbom.create', compact('sbom', 'sbom_id'));
    }

    public function store(Request $request, $sbom_id)
    {
        $validated = $request->validate([
            'primitif_kriptografi' => 'nullable|string|max:255',
            'algoritma_kriptografi' => 'nullable|string|max:255',
            'panjang_kunci' => 'nullable|string|max:255',
            'tujuan_penggunaan' => 'nullable|string',
            'library_modules' => 'nullable|string',
            'kategori_data' => 'nullable|string|max:255',
            'sokongan_crypto_agility' => 'nullable|string|max:255',
        ]);

        CBOM::create([
            'sbom_id' => $sbom_id,
            'primitif_kriptografi' => $validated['primitif_kriptografi'],
            'algoritma_kriptografi' => $validated['algoritma_kriptografi'],
            'panjang_kunci' => $validated['panjang_kunci'],
            'tujuan_penggunaan' => $validated['tujuan_penggunaan'],
            'library_modules' => $validated['library_modules'],
            'kategori_data' => $validated['kategori_data'],
            'sokongan_crypto_agility' => $validated['sokongan_crypto_agility'],
        ]);

        return redirect()->route('entiti.pengurusan_inventori.sbom.show', ['sbom_id' => $sbom_id])
                         ->with('success', 'CBOM berjaya ditambah.');
    }
}
