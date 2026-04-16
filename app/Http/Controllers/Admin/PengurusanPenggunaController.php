<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agensi;
use App\Models\JenisPengguna;
use App\Models\User;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PengurusanPenggunaController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::with(['agensi', 'jenisPengguna']);

        // Search by username
        if ($request->filled('search')) {
            $query->where('username', 'like', '%' . $request->search . '%');
        }

        // Filter by user type (jenis pengguna)
        if ($request->filled('jenis_pengguna')) {
            $query->whereHas('jenisPengguna', function ($roleQuery) use ($request) {
                $roleQuery->where('jenis_pengguna', $request->jenis_pengguna);
            });
        }

        $users = $query->paginate(15);

        return view('admin.pengurusan_pengguna.index', compact('users'));
    }

    /**
     * Show the form for creating new user
     */
    public function create()
    {
        $agensis = Agensi::all();
        $jenisPenggunas = JenisPengguna::orderBy('role_id')->get();

        return view('admin.pengurusan_pengguna.create', compact('agensis', 'jenisPenggunas'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'jenis_pengguna_id' => 'required|exists:jenis_pengguna,role_id',
            'agensi_id' => 'nullable|exists:agensi,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $jenisPengguna = JenisPengguna::find($validated['jenis_pengguna_id']);
        if ($jenisPengguna?->jenis_pengguna === 'Entiti (Agensi)' && empty($validated['agensi_id'])) {
            return back()
                ->withErrors(['agensi_id' => 'Agensi wajib dipilih untuk pengguna Entiti.'])
                ->withInput();
        }

        if ($jenisPengguna?->jenis_pengguna !== 'Entiti (Agensi)') {
            $validated['agensi_id'] = null;
        }

        $user = User::create($validated);

        AuditLogger::log(
            action: 'create',
            module: 'Pengurusan Pengguna',
            description: 'Pengguna baharu didaftarkan.',
            model: $user,
            newValues: Arr::except($validated, ['password'])
        );

        return redirect()->route('admin.pengurusan_pengguna.index')
                       ->with('success', 'Pengguna berjaya didaftarkan');
    }

    /**
     * Display the specified user
     */
    public function show($id)
    {
        $user = User::with(['agensi', 'jenisPengguna'])->findOrFail($id);

        return view('admin.pengurusan_pengguna.show', compact('user'));
    }

    /**
     * Show the form for editing user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $agensis = Agensi::all();
        $jenisPenggunas = JenisPengguna::orderBy('role_id')->get();

        return view('admin.pengurusan_pengguna.edit', compact('user', 'agensis', 'jenisPenggunas'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'jenis_pengguna_id' => 'required|exists:jenis_pengguna,role_id',
            'agensi_id' => 'nullable|exists:agensi,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $jenisPengguna = JenisPengguna::find($validated['jenis_pengguna_id']);
        if ($jenisPengguna?->jenis_pengguna === 'Entiti (Agensi)' && empty($validated['agensi_id'])) {
            return back()
                ->withErrors(['agensi_id' => 'Agensi wajib dipilih untuk pengguna Entiti.'])
                ->withInput();
        }

        if ($jenisPengguna?->jenis_pengguna !== 'Entiti (Agensi)') {
            $validated['agensi_id'] = null;
        }

        $oldValues = Arr::except($user->only([
            'username',
            'jenis_pengguna_id',
            'agensi_id',
        ]), ['password']);

        if (!$request->filled('password')) {
            unset($validated['password']);
        }

        $user->update($validated);

        AuditLogger::log(
            action: 'update',
            module: 'Pengurusan Pengguna',
            description: 'Maklumat pengguna dikemas kini.',
            model: $user,
            oldValues: $oldValues,
            newValues: Arr::except($validated, ['password'])
        );

        return redirect()->route('admin.pengurusan_pengguna.index')
                       ->with('success', 'Pengguna berjaya dikemas kini');
    }

    /**
     * Remove the specified user (prevent deleting current user)
     */
    public function destroy($id)
    {
        // Prevent user from deleting themselves
        if ($id == auth()->id()) {
            return redirect()->route('admin.pengurusan_pengguna.index')
                           ->with('error', 'Anda tidak boleh memadam akaun anda sendiri');
        }

        $user = User::findOrFail($id);
        $oldValues = $user->only([
            'username',
            'jenis_pengguna_id',
            'agensi_id',
        ]);

        $user->delete();

        AuditLogger::log(
            action: 'delete',
            module: 'Pengurusan Pengguna',
            description: 'Pengguna dihapuskan.',
            model: $user,
            oldValues: $oldValues
        );

        return redirect()->route('admin.pengurusan_pengguna.index')
                       ->with('success', 'Pengguna berjaya dihapus');
    }
}
