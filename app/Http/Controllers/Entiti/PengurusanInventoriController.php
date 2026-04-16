<?php

namespace App\Http\Controllers\Entiti;

use App\Http\Controllers\Controller;
use App\Models\Inventori;
use App\Models\SBOM;
use Illuminate\Http\Request;

class PengurusanInventoriController extends Controller
{
    /**
     * Display a listing of inventory items
     */
    public function index(Request $request)
    {
        // Fetch inventory data for the user's agency
        $user = auth()->user();
        $inventori = Inventori::where('agensi_id', $user->agensi_id)->get();

        // Pass data to the view
        return view('entiti.pengurusan_inventori.index', compact('inventori'));
    }

    /**
     * Show the form for creating new inventory item
     */
    public function create()
    {
        $user = auth()->user();
        return view('entiti.pengurusan_inventori.create', ['agensi_id' => $user->agensi_id]);
    }

    /**
     * Store a newly created inventory item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_aset' => 'required|string|max:255',
            'nama_aset' => 'required|string|max:255',
            'lokasi_pemilik' => 'required|string|max:255',
            'sistem_legasi' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $user = auth()->user();

        Inventori::create([
            'agensi_id' => $user->agensi_id,
            'jenis_aset' => $validated['jenis_aset'],
            'nama_aset' => $validated['nama_aset'],
            'lokasi_pemilik' => $validated['lokasi_pemilik'],
            'sistem_legasi' => $validated['sistem_legasi'],
            'catatan' => $validated['catatan'],
        ]);

        return redirect()->route('entiti.pengurusan_inventori.index')
                       ->with('success', 'Inventori berjaya ditambah.');
    }

    /**
     * Display the specified inventory item
     */
    public function show($id)
    {
        $inventory = Inventori::select('id', 'nama_aset as nama_inventori', 'jenis_aset as kategori', 'sistem_legasi as bilangan', 'lokasi_pemilik as lokasi', 'catatan as keterangan', 'created_at')
            ->findOrFail($id);

        // Fetch related SBOMs for the inventory
        $sboms = SBOM::select('id', 'komponen_versi', 'sub_komponen', 'url', 'mod_perkhidmatan', 'language_framework', 'modules_libraries', 'external_apis_services', 'in_house_vendor', 'nama_vendor', 'kepakaran_kriptografi', 'inventori_id')
            ->where('inventori_id', $id)
            ->get();

        return view('entiti.pengurusan_inventori.show', compact('inventory', 'sboms'));
    }

    /**
     * Show the form for editing inventory item
     */
    public function edit($id)
    {
        $inventory = Inventori::findOrFail($id);

        return view('entiti.pengurusan_inventori.edit', compact('inventory'));
    }

    /**
     * Update the specified inventory item
     */
    public function update(Request $request, $id)
    {
        $inventory = Inventori::findOrFail($id);

        $validated = $request->validate([
            'nama_inventori' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:128',
            'bilangan' => 'required|integer|min:0',
            'lokasi' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,tidak_aktif',
            'keterangan' => 'nullable|string',
        ]);

        $inventory->update([
            'nama_aset' => $validated['nama_inventori'],
            'jenis_aset' => $validated['kategori'] ?? 'Umum',
            'lokasi_pemilik' => $validated['lokasi'] ?? null,
            'catatan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('entiti.pengurusan_inventori.index')
                       ->with('success', 'Inventori berjaya dikemas kini');
    }

    /**
     * Remove the specified inventory item
     */
    public function destroy($id)
    {
        $inventory = Inventori::findOrFail($id);
        $inventory->delete();

        return redirect()->route('entiti.pengurusan_inventori.index')
                       ->with('success', 'Inventori berjaya dihapus');
    }
}
