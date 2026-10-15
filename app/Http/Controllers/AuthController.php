<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function formLogin()
    {
        return view('auth.login');
    }

    public function formRegister()
    {
        return view('auth.register');
    }

    public function ProcessRegister(Request $request)
    {
        // Validasi input dari pengguna
        $validatedData = $request->validate([
            "name" => "required|string|max:255", 
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8|confirmed", // confirmed berarti butuh input password_confirmation
            "phone_number" => "required|string|max:15",
        ]);

        // Membuat user baru di database
        $user = User::create([
            "name" => $validatedData["name"],
            "email" => $validatedData["email"],
            "password" => Hash::make($validatedData["password"]), // Mengamankan password dengan hashing
            "phone_number" => $validatedData["phone_number"],
            "role" => "pelanggan" // Default role untuk registrasi baru
        ]);

        // Login otomatis setelah registrasi berhasil
        Auth::login($user);
        return redirect("/katalog")->with("success", "Registrasi berhasil!");
    }

    /**
     * Memproses upaya login pengguna.
     */
    public function ProcessLogin(Request $request)
    {
        // Validasi format email dan password
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // Mencoba mencocokkan kredensial dengan database
        if (Auth::attempt($credentials)) {
            // Mencegah Session Fixation
            $request->session()->regenerate();
            
            $userRole = Auth::user()->role;
            
            // Pengalihan halaman berdasarkan role pengguna
            if ($userRole === 'admin' || $userRole === 'karyawan') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect('/katalog');
            }
        }

        // Kembali ke halaman login dengan pesan error jika gagal
        return back()->withErrors([
            'email' => 'Akses Ditolak! Email atau password tidak cocok dengan sistem kami.'
        ]);
    }

    /**
     * Memproses logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
