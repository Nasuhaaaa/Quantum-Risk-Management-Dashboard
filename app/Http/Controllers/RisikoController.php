<?php

namespace App\Http\Controllers;
use App\Models\KategoriRisiko;
use App\Models\SubKategoriRisiko;
use App\Models\Risiko;
use Illuminate\Http\Request;

class RisikoController extends Controller
{
    //
    public function create()
    {
        $kategoriRisiko = KategoriRisiko::all();
        $subKategoriRisiko = SubKategoriRisiko::all();
        // check whether the query is correct
        // dd($kategoriRisiko->toArray());
        return view('risiko.create', compact('kategoriRisiko', 'subKategoriRisiko'));
    }

    public function store(Request $request)
    {
        // later: validation + save to DB

        // for now the only the subkategiri risiko is being validated.
        $validateData = $request->validate([
            'nama_risiko' => 'required|string|max:255|unique:risiko,nama_risiko',
            'sub_kategori_risiko_id' => 'required|exists:sub_kategori_risiko,id',
            'kategori_risiko_id' => 'required|exists:kategori_risiko,id',
        ]);

        Risiko::create($validateData);

        return redirect()->route('risiko.create')
                         ->with('success', 'Data berjaya disimpan!')
                         ->withInput();
    }
}
