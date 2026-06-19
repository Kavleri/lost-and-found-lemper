<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Tampilkan daftar semua user
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nim_nip', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('user.index', compact('users'));
    }

    /**
     * Tampilkan form tambah user
     */
    public function create()
    {
        return view('user.create-user');
    }

    /**
     * Simpan user baru ke database
     */
    public function store(Request $request)
    {
        // Validasi langsung di controller
        $validated = $request->validate([
            'nim_nip' => 'nullable|string|max:20|unique:users,nim_nip',
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:mahasiswa,dosen,staf,satpam,admin',
            'phone' => 'nullable|string|max:15',
            'department' => 'nullable|string|max:50',
            'is_verified' => 'nullable|boolean',
        ], [
            'nim_nip.unique' => 'NIM/NIP sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'role.in' => 'Role tidak valid.',
        ]);

        // Hash password
        $validated['password'] = Hash::make($validated['password']);
        $validated['is_verified'] = $request->boolean('is_verified', false);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail user
     */
    public function show(User $user)
    {
        // Load relasi untuk statistik
        $user->loadCount(['reportedItems', 'foundItems', 'claims', 'notifications']);

        return view('user.detail-user', compact('user'));
    }

    /**
     * Tampilkan form edit user
     */
    public function edit(User $user)
    {
        return view('user.edit-user', compact('user'));
    }

    /**
     * Update user di database
     */
    public function update(Request $request, User $user)
    {
        // Validasi dengan ignore user yang sedang diupdate
        $validated = $request->validate([
            'nim_nip' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('users')->ignore($user->id),
            ],
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:mahasiswa,dosen,staf,satpam,admin',
            'phone' => 'nullable|string|max:15',
            'department' => 'nullable|string|max:50',
            'is_verified' => 'nullable|boolean',
        ], [
            'nim_nip.unique' => 'NIM/NIP sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // Hanya update password jika diisi
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_verified'] = $request->boolean('is_verified', false);

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Hapus user dari database
     */
    public function destroy(User $user)
    {
        // Cegah admin menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}
