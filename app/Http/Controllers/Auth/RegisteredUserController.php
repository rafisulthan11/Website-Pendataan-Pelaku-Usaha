<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
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
        if ($request->filled('name') && !$request->filled('nama_lengkap')) {
            $request->merge([
                'nama_lengkap' => $request->input('name'),
            ]);
        }

        $request->validate([
        'nama_lengkap' => ['required', 'string', 'max:255'], // Ganti 'name' menjadi 'nama_lengkap'
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $staffRole = Role::firstOrCreate(['nama_role' => 'staff']);
        $nip = $this->generateUniqueNip();

        $user = User::create([
        'nama_lengkap' => $request->nama_lengkap, // Ganti 'name' menjadi 'nama_lengkap'
        'nip' => $nip,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'id_role' => $staffRole->id_role,
        'status' => 'aktif', // Otomatis set status sebagai 'aktif'
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    private function generateUniqueNip(): string
    {
        do {
            $nip = str_pad((string) random_int(1, 999999999999999999), 18, '0', STR_PAD_LEFT);
        } while (User::where('nip', $nip)->exists());

        return $nip;
    }
}
