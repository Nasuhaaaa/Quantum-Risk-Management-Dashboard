<?php

namespace App\Http\Controllers\KethuaSektor;

use App\Http\Controllers\Controller;
use App\Models\Agensi;
use App\Models\Sektor;
use Illuminate\Http\Request;

class PengurusanAgensiController extends Controller
{
    /**
     * Display a listing of entities in the sector
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $sektor = $user->agensi?->sektor;

        $query = Agensi::where('sektor_id', $sektor?->id)
            ->with('sektor');

        // Search by entity name
        if ($request->filled('search')) {
            $query->where('nama_agensi', 'like', '%' . $request->search . '%');
        }

        $entities = $query->paginate(10);

        return view('ketua_sektor.pengurusan_agensi.index', compact('entities', 'sektor'));
    }

    /**
     * Show the form for creating entity
     */
    public function create()
    {
        $user = auth()->user();
        $sektor = $user->agensi?->sektor;

        return view('ketua_sektor.pengurusan_agensi.create', compact('sektor'));
    }

    /**
     * Store a newly created entity
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $sektor = $user->agensi?->sektor;

        $validated = $request->validate([
            'nama_agensi' => 'required|string|max:255|unique:agensi',
            'no_tel_agensi' => 'required|string|max:20',
            'website' => 'nullable|url',
            'nama_pic' => 'required|string|max:255',
            'no_tel_pic' => 'required|string|max:20',
            'emel_pic' => 'required|email',
        ]);

        $validated['sektor_id'] = $sektor?->id;

        Agensi::create($validated);

        return redirect()->route('sektor.pengurusan_agensi.index')
                       ->with('success', 'Entiti berjaya didaftarkan');
    }

    /**
     * Display the specified entity
     */
    public function show($id)
    {
        $entity = Agensi::findOrFail($id);

        return view('ketua_sektor.pengurusan_agensi.show', compact('entity'));
    }

    /**
     * Show the form for editing entity
     */
    public function edit($id)
    {
        $entity = Agensi::findOrFail($id);
        $user = auth()->user();
        $sektor = $user->agensi?->sektor;

        // Verify that the entity belongs to the user's sector
        if ($entity->sektor_id !== $sektor?->id) {
            abort(403, 'Unauthorized access');
        }

        return view('ketua_sektor.pengurusan_agensi.edit', compact('entity'));
    }

    /**
     * Update the specified entity
     */
    public function update(Request $request, $id)
    {
        $entity = Agensi::findOrFail($id);
        $user = auth()->user();
        $sektor = $user->agensi?->sektor;

        // Verify that the entity belongs to the user's sector
        if ($entity->sektor_id !== $sektor?->id) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'nama_agensi' => 'required|string|max:255|unique:agensi,nama_agensi,' . $id,
            'no_tel_agensi' => 'required|string|max:20',
            'website' => 'nullable|url',
            'nama_pic' => 'required|string|max:255',
            'no_tel_pic' => 'required|string|max:20',
            'emel_pic' => 'required|email',
        ]);

        $entity->update($validated);

        return redirect()->route('sektor.pengurusan_agensi.index')
                       ->with('success', 'Entiti berjaya dikemas kini');
    }

    /**
     * Remove the specified entity
     */
    public function destroy($id)
    {
        $entity = Agensi::findOrFail($id);
        $user = auth()->user();
        $sektor = $user->agensi?->sektor;

        // Verify that the entity belongs to the user's sector
        if ($entity->sektor_id !== $sektor?->id) {
            abort(403, 'Unauthorized access');
        }

        $entity->delete();

        return redirect()->route('sektor.pengurusan_agensi.index')
                       ->with('success', 'Entiti berjaya dihapus');
    }
}
