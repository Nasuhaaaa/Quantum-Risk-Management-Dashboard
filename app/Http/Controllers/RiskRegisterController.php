<?php

namespace App\Http\Controllers;

use App\Models\RegisterRisk;
use App\Models\KategoriRisiko;
use App\Models\SubKategoriRisiko;
use App\Models\Risiko;
use App\Models\KategoriPuncaRisiko;
use App\Models\PuncaRisiko;
use App\Models\Impak;
use App\Models\Kebarangkalian;
use App\Models\TahapRisiko;
use Illuminate\Http\Request;
use App\Models\CBOM;

class RiskRegisterController extends Controller
{
    /**
     * Show the form for creating a new risk registration
     */
    public function create(Request $request)
    {
        $kategoriRisiko = KategoriRisiko::all();
        $subKategoriRisiko = SubKategoriRisiko::all();
        $risiko = Risiko::all();
        $kategoriPuncaRisiko = KategoriPuncaRisiko::all();
        $puncaRisiko = PuncaRisiko::all();
        $impak = Impak::all();
        $kebarangkalian = Kebarangkalian::all();
        $tahapRisiko = TahapRisiko::all();

        $cbom = null;

        if ($request->has('cbom_id')) {
            $cbom = CBOM::with(['sbom.inventori'])->find($request->get('cbom_id'));
            // Debugging CBOM data
            if (!$cbom) {
                dd('CBOM not found for ID: ' . $request->get('cbom_id'));
            }
        }

        return view('risk_register.create', compact(
            'kategoriRisiko',
            'subKategoriRisiko',
            'risiko',
            'kategoriPuncaRisiko',
            'puncaRisiko',
            'impak',
            'kebarangkalian',
            'tahapRisiko',
            'cbom'
        ));
    }

    /**
     * Store a newly created risk registration in database
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'cbom_id' => 'required|exists:cbom,id',
            'risiko_id' => 'required|exists:risiko,id',
            'pemilik_risiko' => 'required|string|max:255',
            'punca_risiko_id' => 'required|exists:punca_risiko,id',
            'impak_id' => 'required|exists:impak,impak_id',
            'kebarangkalian_id' => 'required|exists:kebarangkalian,kebarangkalian_id',
            'skor_risiko' => 'required|integer|min:1|max:25',
            'tahap_risiko_id' => 'required|exists:tahap_risiko,tahap_risiko_id',
            'kawalan_sedia_ada' => 'nullable|string',
            'pelan_mitigasi' => 'nullable|string',
        ]);

        RegisterRisk::create($validated);

        return redirect()->route('entiti.pengurusan_inventori.show', ['id' => CBOM::find($validated['cbom_id'])->sbom->inventori_id])
                       ->with('success', 'Risiko berjaya didaftarkan');
    }
}
