<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function create()
    {
        return view('login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        // Membuat key unik berdasarkan username dan IP pengguna
        $key = 'login-attempts:' . $request->input('username') . '|' . $request->ip();

        // Memeriksa apakah sudah terlalu banyak percobaan
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->with('blocked', 'Terlalu banyak percobaan login. Silakan coba lagi nanti.')->withInput();
        }

        // $user = User::where('username', $credentials['username'])->first();

        // if (!$user || !$user->isAktif) {
        //     RateLimiter::hit($key, 60);
        //     $message = !$user ? 'Username atau Password tidak sesuai' : 'User ini sudah tidak aktif lagi. Silakan menghubungi sekretariat.';
        //     return back()->with('failed', $message);
        // }

        if (Auth::attempt($credentials)) {
            // Jika autentikasi berhasil, reset hit
            RateLimiter::clear($key);

            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        // Jika autentikasi gagal, tambahkan hit
        RateLimiter::hit($key, 60); // 60 detik decay time

        return back()->with('failed', 'Username atau Password tidak sesuai');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
