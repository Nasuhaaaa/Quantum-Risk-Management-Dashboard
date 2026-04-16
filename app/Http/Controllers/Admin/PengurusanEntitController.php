<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agensi;
use App\Models\Sektor;
use Illuminate\Http\Request;

class PengurusanEntitController extends Controller
{
    /**
     * Display a listing of entities
     */
    public function index(Request $request)
    {
        $query = Agensi::with('sektor');

        // Search by entity name
        if ($request->filled('search')) {
            $query->where('nama_agensi', 'like', '%' . $request->search . '%');
        }

        $entities = $query->paginate(15);

        return view('admin.pengurusan_entiti.index', compact('entities'));
    }

    /**
     * Show the form for creating new entity
     */
    public function create()
    {
        $sectors = Sektor::all();

        return view('admin.pengurusan_entiti.create', compact('sectors'));
    }

    /**
     * Store a newly created entity
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_agensi' => 'required|string|max:150|unique:agensi,nama_agensi',
            'no_tel_agensi' => 'nullable|string|max:50',
            'website' => 'nullable|url',
            'nama_pic' => 'nullable|string|max:150',
            'no_tel_pic' => 'nullable|string|max:50',
            'emel_pic' => 'nullable|email|max:255',
            'sektor_id' => 'nullable|exists:sektor,id',
            'jenis_perniagaan_perhubungan' => 'nullable|string|max:255',
        ]);

        Agensi::create($validated);

        return redirect()->route('admin.pengurusan_entiti.index')
                       ->with('success', 'Entiti berjaya didaftarkan');
    }

    /**
     * Display the specified entity
     */
    public function show($id)
    {
        $entity = Agensi::with('sektor', 'users')->findOrFail($id);

        return view('admin.pengurusan_entiti.show', compact('entity'));
    }

    /**
     * Show the form for editing entity
     */
    public function edit($id)
    {
        $entity = Agensi::findOrFail($id);
        $sectors = Sektor::all();

        return view('admin.pengurusan_entiti.edit', compact('entity', 'sectors'));
    }

    /**
     * Update the specified entity
     */
    public function update(Request $request, $id)
    {
        $entity = Agensi::findOrFail($id);

        $validated = $request->validate([
            'nama_agensi' => 'required|string|max:150|unique:agensi,nama_agensi,' . $id,
            'no_tel_agensi' => 'nullable|string|max:50',
            'website' => 'nullable|url',
            'nama_pic' => 'nullable|string|max:150',
            'no_tel_pic' => 'nullable|string|max:50',
            'emel_pic' => 'nullable|email|max:255',
            'sektor_id' => 'nullable|exists:sektor,id',
            'jenis_perniagaan_perhubungan' => 'nullable|string|max:255',
        ]);

        $entity->update($validated);

        return redirect()->route('admin.pengurusan_entiti.index')
                       ->with('success', 'Entiti berjaya dikemas kini');
    }

    /**
     * Remove the specified entity
     */
    public function destroy($id)
    {
        $entity = Agensi::findOrFail($id);

        // Check if entity has users
        if ($entity->users()->count() > 0) {
            return redirect()->route('admin.pengurusan_entiti.index')
                           ->with('error', 'Tidak boleh memadam entiti yang mempunyai pengguna terdaftar');
        }

        $entity->delete();

        return redirect()->route('admin.pengurusan_entiti.index')
                       ->with('success', 'Entiti berjaya dihapus');
    }
}
