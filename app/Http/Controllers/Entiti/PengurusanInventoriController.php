<?php

namespace App\Http\Controllers\Entiti;

use App\Http\Controllers\Controller;
use App\Models\Inventori;
use Illuminate\Http\Request;

class PengurusanInventoriController extends Controller
{
    /**
     * Display a listing of inventory items
     */
    public function index(Request $request)
    {
        $query = Inventori::query();

        // Search by name
        if ($request->filled('search')) {
            $query->where('nama_aset', 'like', '%' . $request->search . '%')
                  ->orWhere('jenis_aset', 'like', '%' . $request->search . '%');
        }

        // Filter by status (simulated - would need status field in database)
        if ($request->filled('status')) {
            // TODO: Add status field to inventori table if needed
        }

        $inventories = $query->paginate(10);

        return view('entiti.pengurusan_inventori.index', compact('inventories'));
    }

    /**
     * Show the form for creating new inventory item
     */
    public function create()
    {
        return view('entiti.pengurusan_inventori.create');
    }

    /**
     * Store a newly created inventory item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_inventori' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:128',
            'bilangan' => 'required|integer|min:0',
            'lokasi' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,tidak_aktif',
            'keterangan' => 'nullable|string',
        ]);

        Inventori::create([
            'nama_aset' => $validated['nama_inventori'],
            'jenis_aset' => $validated['kategori'] ?? 'Umum',
            'lokasi_pemilik' => $validated['lokasi'] ?? null,
            'sistem_legasi' => $validated['bilangan'] ?? 0,
            'catatan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('entiti.pengurusan_inventori.index')
                       ->with('success', 'Inventori berjaya ditambah');
    }

    /**
     * Display the specified inventory item
     */
    public function show($id)
    {
        $inventory = Inventori::findOrFail($id);

        return view('entiti.pengurusan_inventori.show', compact('inventory'));
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
