<?php

namespace App\Http\Controllers\Entiti\SBOM;

use App\Http\Controllers\Controller;
use App\Models\SBOM;
use App\Models\CBOM;
use Illuminate\Http\Request;

class SBOMController extends Controller
{
    /**
     * Display a listing of SBOMs for the selected inventory.
     */
    public function index($inventori_id)
    {
        // Fetch SBOMs related to the selected inventory
        $sboms = SBOM::where('inventori_id', $inventori_id)->get();

        // Pass data to the view
        return view('entiti.pengurusan_inventori.sbom.index', compact('sboms', 'inventori_id'));
    }

    /**
     * Display the specified SBOM and its related CBOMs.
     */
    public function show($sbom_id)
    {
        // Debugging: Log the received sbom_id
        \Log::info('Received sbom_id: ' . $sbom_id);

        // Fetch the SBOM details
        $sbom = SBOM::findOrFail($sbom_id);

        // Fetch related CBOMs for the SBOM
        $cboms = CBOM::where('sbom_id', $sbom_id)->get();

        // Pass data to the view
        return view('entiti.pengurusan_inventori.sbom.show', compact('sbom', 'cboms'));
    }

    /**
     * Show the form for creating a new SBOM.
     */
    public function create($inventori_id)
    {
        return view('entiti.pengurusan_inventori.sbom.create', compact('inventori_id'));
    }

    public function store(Request $request, $inventori_id)
    {
        $validated = $request->validate([
            'komponen_versi' => 'required|string|max:255',
            'sub_komponen' => 'nullable|string',
            'url' => 'nullable|string',
            'mod_perkhidmatan' => 'nullable|string|max:255',
            'language_framework' => 'nullable|string|max:255',
            'modules_libraries' => 'nullable|string',
            'external_apis_services' => 'nullable|string|max:255',
            'in_house_vendor' => 'nullable|string|max:255',
            'nama_vendor' => 'nullable|string|max:255',
            'kepakaran_kriptografi' => 'nullable|string|max:255',
        ]);

        SBOM::create([
            'inventori_id' => $inventori_id,
            'komponen_versi' => $validated['komponen_versi'],
            'sub_komponen' => $validated['sub_komponen'],
            'url' => $validated['url'],
            'mod_perkhidmatan' => $validated['mod_perkhidmatan'],
            'language_framework' => $validated['language_framework'],
            'modules_libraries' => $validated['modules_libraries'],
            'external_apis_services' => $validated['external_apis_services'],
            'in_house_vendor' => $validated['in_house_vendor'],
            'nama_vendor' => $validated['nama_vendor'],
            'kepakaran_kriptografi' => $validated['kepakaran_kriptografi'],
        ]);

        return redirect()->route('entiti.pengurusan_inventori.show', ['id' => $inventori_id])
                         ->with('success', 'SBOM berjaya ditambah.');
    }

}
