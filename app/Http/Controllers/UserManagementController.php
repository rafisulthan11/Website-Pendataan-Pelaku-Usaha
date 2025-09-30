<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('role')->latest()->get();
        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('pages.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'id_role' => ['required', 'exists:roles,id_role'],
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_role' => $request->id_role,
            'status' => 'aktif',
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }
    /**
     * Menampilkan form untuk mengedit user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('pages.users.edit', compact('user', 'roles'));
    }

    /**
     * Mengupdate data user di database.
     */
    public function update(Request $request, User $user)
    {
        // Validasi input
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id_user.',id_user'],
            'id_role' => ['required', 'exists:roles,id_role'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        // Update data user
        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'id_role' => $request->id_role,
        ]);

        // Jika ada password baru, update passwordnya
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Tambahkan logika agar user tidak bisa menghapus dirinya sendiri
        if ($user->id_user === Auth::user()->id_user) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}