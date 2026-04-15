<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agensi;
use Illuminate\Http\Request;

class PengurusanPenggunaController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::with('agensi');

        // Search by name or email
        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        // Filter by user type (jenis pengguna)
        if ($request->filled('jenis_pengguna')) {
            $query->where('jenis_pengguna', $request->jenis_pengguna);
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

        return view('admin.pengurusan_pengguna.create', compact('agensis'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'no_telefon' => 'nullable|string|max:20',
            'jenis_pengguna' => 'required|in:entiti,ketua_sektor,pengurusan,admin',
            'id_agensi' => 'nullable|exists:agensi,id',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'required|boolean',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('admin.pengurusan_pengguna.index')
                       ->with('success', 'Pengguna berjaya didaftarkan');
    }

    /**
     * Display the specified user
     */
    public function show($id)
    {
        $user = User::with('agensi')->findOrFail($id);

        return view('admin.pengurusan_pengguna.show', compact('user'));
    }

    /**
     * Show the form for editing user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $agensis = Agensi::all();

        return view('admin.pengurusan_pengguna.edit', compact('user', 'agensis'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'no_telefon' => 'nullable|string|max:20',
            'jenis_pengguna' => 'required|in:entiti,ketua_sektor,pengurusan,admin',
            'id_agensi' => 'nullable|exists:agensi,id',
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'required|boolean',
        ]);

        // Only hash password if provided
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

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
        $user->delete();

        return redirect()->route('admin.pengurusan_pengguna.index')
                       ->with('success', 'Pengguna berjaya dihapus');
    }
}

}
