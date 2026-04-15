<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sektor;
use Illuminate\Http\Request;

class PengurusanSektorController extends Controller
{
    /**
     * Display a listing of sectors
     */
    public function index(Request $request)
    {
        $query = Sektor::withCount('agensis as entity_count');

        // Search by sector name
        if ($request->filled('search')) {
            $query->where('nama_sektor', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            // TODO: Add status field to sektor table if needed
        }

        $sectors = $query->paginate(15);

        return view('admin.pengurusan_sektor.index', compact('sectors'));
    }

    /**
     * Show the form for creating new sector
     */
    public function create()
    {
        return view('admin.pengurusan_sektor.create');
    }

    /**
     * Store a newly created sector
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sektor' => 'required|string|max:255|unique:sektor',
            'pengurus_sektor' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'no_telefon' => 'nullable|string|max:20',
            'keterangan' => 'nullable|string',
        ]);

        // Map form fields to model fields
        Sektor::create([
            'nama_sektor' => $validated['nama_sektor'],
            'ketua_sektor' => $validated['pengurus_sektor'] ?? null,
            'keterangan_sektor' => $validated['keterangan'] ?? null,
            'maklumat_perhubungan_sektor' => ($validated['email'] ?? '') . ' | ' . ($validated['no_telefon'] ?? ''),
        ]);

        return redirect()->route('admin.pengurusan_sektor.index')
                       ->with('success', 'Sektor berjaya ditambah');
    }

    /**
     * Display the specified sector
     */
    public function show($id)
    {
        $sector = Sektor::with('agensis')->findOrFail($id);

        return view('admin.pengurusan_sektor.show', compact('sector'));
    }

    /**
     * Show the form for editing sector
     */
    public function edit($id)
    {
        $sector = Sektor::findOrFail($id);

        return view('admin.pengurusan_sektor.edit', compact('sector'));
    }

    /**
     * Update the specified sector
     */
    public function update(Request $request, $id)
    {
        $sector = Sektor::findOrFail($id);

        $validated = $request->validate([
            'nama_sektor' => 'required|string|max:255|unique:sektor,nama_sektor,' . $id,
            'pengurus_sektor' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'no_telefon' => 'nullable|string|max:20',
            'keterangan' => 'nullable|string',
        ]);

        // Map form fields to model fields
        $sector->update([
            'nama_sektor' => $validated['nama_sektor'],
            'ketua_sektor' => $validated['pengurus_sektor'] ?? null,
            'keterangan_sektor' => $validated['keterangan'] ?? null,
            'maklumat_perhubungan_sektor' => ($validated['email'] ?? '') . ' | ' . ($validated['no_telefon'] ?? ''),
        ]);

        return redirect()->route('admin.pengurusan_sektor.index')
                       ->with('success', 'Sektor berjaya dikemas kini');
    }

    /**
     * Remove the specified sector
     */
    public function destroy($id)
    {
        $sector = Sektor::findOrFail($id);

        // Check if sector has agencies
        if ($sector->agensis()->count() > 0) {
            return redirect()->route('admin.pengurusan_sektor.index')
                           ->with('error', 'Tidak boleh memadam sektor yang mempunyai agensi terdaftar');
        }

        $sector->delete();

        return redirect()->route('admin.pengurusan_sektor.index')
                       ->with('success', 'Sektor berjaya dihapus');
    }
}
