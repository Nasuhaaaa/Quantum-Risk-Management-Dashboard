<?php

namespace App\Http\Controllers;

use App\Models\KategoriRisiko;
use Illuminate\Http\Request;

class KategoriRisikoController extends Controller
{
    //
     public function create()
    {
        return view('kategori_risiko.create');
    }

    public function store(Request $request)
    {
        // later: validation + save to DB

        $validateData = $request->validate([
            'kategori_risiko' => 'required|string|max:255|unique:kategori_risiko,kategori_risiko',], ['kategori_risiko.unique' => 'Kategori risiko ini sudah wujud.',
        ]);

        KategoriRisiko::create($validateData);

        return redirect()->route('kategori_risiko.create')
                         ->with('success', 'Data berjaya disimpan!')
                         ->withInput();
    }
}
