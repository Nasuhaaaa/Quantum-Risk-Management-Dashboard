<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriPuncaRisiko;
use App\Models\PuncaRisiko;

class PuncaRisikoController extends Controller
{
    //
    public function create()
    {
        $kategoriPuncaRisiko = KategoriPuncaRisiko::all();
        // check whether the query is correct
        // dd($kategoriPuncaRisiko->toArray());
        return view('punca_risiko.create', compact('kategoriPuncaRisiko'));
    }

    public function store(Request $request)
    {
        // later: validation + save to DB

        // for now the only the subkategiri risiko is being validated.
        $validateData = $request->validate([
            'punca_risiko' => 'required|string|max:255|unique:punca_risiko,punca_risiko',
            'kategori_punca_risiko_id' => 'required|exists:kategori_punca_risiko,id',
            'pelan_mitigasi' => 'nullable|string|max:255',
        ]);

        PuncaRisiko::create($validateData);

        return redirect()->route('punca_risiko.create')
                         ->with('success', 'Data berjaya disimpan!')
                         ->withInput();
    }
}
