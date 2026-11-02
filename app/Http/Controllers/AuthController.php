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
            "password" => "required|min:8|confirmed",
            "phone_number" => "required|string|max:15",
        ]);

        // Membuat user baru di database
        $user = User::create([
            "name" => $validatedData["name"],
            "email" => $validatedData["email"],
            "password" => Hash::make($validatedData["password"]),
            "phone_number" => $validatedData["phone_number"],
            "role" => "pelanggan",
            "status_akun" => "aktif"
        ]);

        // Login otomatis setelah registrasi berhasil
        Auth::login($user);

        return redirect("/katalog")
            ->with("success", "Registrasi berhasil!");
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

        // Mencari pengguna berdasarkan email
        $user = User::where('email', $credentials['email'])->first();

        // Memeriksa status akun pelanggan sebelum login
        if (
            $user &&
            $user->role === 'pelanggan' &&
            $user->status_akun !== 'aktif'
        ) {
            return back()
                ->withErrors([
                    'email' => 'Akun Anda sedang diblokir. Silakan hubungi admin.'
                ])
                ->onlyInput('email');
        }

        // Mencoba mencocokkan email dan password
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

        // Kembali ke halaman login jika kredensial salah
        return back()->withErrors([
            'email' => 'Akses Ditolak! Email atau password tidak cocok dengan sistem kami.'
        ])->onlyInput('email');
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

    public function profilPelanggan()
    {
        $pelanggan = Auth::user();

        return view('auth.profilpelanggan', compact('pelanggan'));
    }

    public function updateProfilPelanggan(Request $request)
    {
        $pelanggan = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pelanggan->id,
            'password' => 'nullable|string|min:8',
            'alamat' => 'nullable|string|max:1000',
            'phone_number' => 'nullable|string|max:15',
        ]);

        $pelanggan->name = $validatedData['name'];
        $pelanggan->email = $validatedData['email'];
        $pelanggan->alamat = $validatedData['alamat'] ?? null;
        $pelanggan->phone_number = $validatedData['phone_number'] ?? null;

        // Password hanya diubah jika diisi
        if (!empty($validatedData['password'])) {
            $pelanggan->password = Hash::make($validatedData['password']);
        }

        $pelanggan->save();

        return redirect()
            ->route('pelanggan.profil')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
