<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriPuncaRisiko;

class KategoriPuncaRisikoController extends Controller
{
    //
      public function create()
    {
        return view('kategori_punca_risiko.create');
    }

    public function store(Request $request)
    {
        // later: validation + save to DB

        $validateData = $request->validate([
            'kategori_punca_risiko' => 'required|string|max:255|unique:kategori_punca_risiko,kategori_punca_risiko',], ['kategori_punca_risiko.unique' => 'Kategori punca risiko ini sudah wujud.',
        ]);

        KategoriPuncaRisiko::create($validateData);

        return redirect()->route('kategori_punca_risiko.create')
                         ->with('success', 'Data berjaya disimpan!')
                         ->withInput();
    }
}
