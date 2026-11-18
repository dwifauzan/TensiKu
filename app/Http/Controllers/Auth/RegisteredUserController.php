<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Create a new user account and log it in.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $penggunaRole = Role::firstOrCreate(['nama_role' => Role::Pengguna]);

        $user = User::create([
            ...$request->safe()->only(['nama', 'email', 'password']),
            'is_active' => true,
            'id_role' => $penggunaRole->id_role,
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}
