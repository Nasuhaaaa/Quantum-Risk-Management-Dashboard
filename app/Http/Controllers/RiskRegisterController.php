<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiskRegisterController extends Controller
{
    //

     public function create()
    {
        return view('risk_register.create');
    }

    public function store(Request $request)
    {
        // later: validation + save to DB

        return redirect()->route('risk_register.create')
                         ->with('success', 'Data saved!');
    }
}
