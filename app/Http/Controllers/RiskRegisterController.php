<?php

namespace App\Http\Controllers;

use App\Models\RegisterRisk;
use App\Models\KategoriRisiko;
use App\Models\SubKategoriRisiko;
use App\Models\Risiko;
use App\Models\KategoriPuncaRisiko;
use App\Models\PuncaRisiko;
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
        $validated['agensi_id'] = $user->agensi_id;
        $validated['status_persetujuan'] = null; // Default to pending approval

        RegisterRisk::create($validated);

        return redirect()->route('entiti.pengurusan_risiko.index')
                       ->with('success', 'Risiko berjaya didaftarkan');
    }
}
