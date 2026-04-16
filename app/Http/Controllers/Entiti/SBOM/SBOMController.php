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


}
