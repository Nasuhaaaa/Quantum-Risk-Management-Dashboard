<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriRisiko;
use App\Models\SubKategoriRisiko;
use App\Models\Risiko;
use App\Models\KategoriPuncaRisiko;
use App\Models\PuncaRisiko;

class RiskRegisterController extends Controller
{
    //

    public function create()
    {
        $kategoriRisiko = KategoriRisiko::all();
        $subKategoriRisiko = SubKategoriRisiko::all();
        $risiko = Risiko::all();
        $kategoriPuncaRisiko = KategoriPuncaRisiko::all();
        $puncaRisiko = PuncaRisiko::all();

        // check whether the query is correct
        // dd($kategoriRisiko->toArray());
        return view('risk_register.create', compact('kategoriRisiko', 'subKategoriRisiko', 'risiko', 'kategoriPuncaRisiko', 'puncaRisiko'));
    }

    public function store(Request $request)
    {
        // later: validation + save to DB

        return redirect()->route('risk_register.create')
                         ->with('success', 'Data saved!');
    }
}
