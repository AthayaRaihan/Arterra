<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Tampilkan halaman register
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses login user
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenerate session biar aman
            $request->session()->regenerate();

            // Redirect ke dashboard
            return redirect()->intended(route('dashboard'));
        }

        // Kalau gagal
        return back()
            ->withErrors([
                'email' => 'Email atau password tidak valid.',
            ])
            ->onlyInput('email');
    }

    /**
     * Proses register user
     */
    public function register(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // Simpan user ke database
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // ❗ Tidak langsung login
        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Hapus session
        $request->session()->invalidate();

        // Generate token baru (CSRF)
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}