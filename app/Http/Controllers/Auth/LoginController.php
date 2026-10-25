<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Memproses login pengurus
    public function login(Request $request)
    {
        // Memeriksa input yang dikirim
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Memeriksa email dan password
        if (Auth::attempt($credentials)) {
            // Membuat ulang session untuk keamanan
            $request->session()->regenerate();

            // Mengarahkan pengguna ke dashboard
            return redirect()->intended('/dashboard');
        }

        // Pesan umum agar detail kegagalan tidak dibocorkan
        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->onlyInput('email');
    }

    // Mengakhiri sesi login
    public function logout(Request $request)
    {
        Auth::logout();

        // Menghapus session lama
        $request->session()->invalidate();

        // Membuat token CSRF baru
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Kamu berhasil logout.');
    }
}