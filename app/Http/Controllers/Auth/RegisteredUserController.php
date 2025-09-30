<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
        'nama_lengkap' => ['required', 'string', 'max:255'], // Ganti 'name' menjadi 'nama_lengkap'
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);


        $user = User::create([
        'nama_lengkap' => $request->nama_lengkap, // Ganti 'name' menjadi 'nama_lengkap'
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'id_role' => 2, // Otomatis set role sebagai 'staff' (asumsi id_role 2 = staff)
        'status' => 'aktif', // Otomatis set status sebagai 'aktif'
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
