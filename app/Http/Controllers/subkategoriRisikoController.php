<?php

namespace App\Http\Controllers;

use App\Models\SubKategoriRisiko;
use App\Models\KategoriRisiko;
use Illuminate\Http\Request;

class SubkategoriRisikoController extends Controller
{
    //
    public function create()
    {
        $kategoriRisiko = KategoriRisiko::all();
        // check whether the query is correct
        // dd($kategoriRisiko->toArray());
        return view('subkategori_risiko.create', compact('kategoriRisiko'));
    }

    public function store(Request $request)
    {
        // later: validation + save to DB

        // for now the only the subkategiri risiko is being validated.
        $validateData = $request->validate([
            'sub_kategori_risiko' => 'required|string|max:255|unique:sub_kategori_risiko,sub_kategori_risiko',
            'kategori_risiko_id' => 'required|exists:kategori_risiko,id',
        ]);

        SubKategoriRisiko::create($validateData);

        return redirect()->route('subkategori_risiko.create')
                         ->with('success', 'Data berjaya disimpan!')
                         ->withInput();
    }
}
