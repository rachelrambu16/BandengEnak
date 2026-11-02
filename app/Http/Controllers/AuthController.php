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
        $validatedData = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8|confirmed",
            "phone_number" => "required|string|max:15",
        ]);

        $user = User::create([
            "name" => $validatedData["name"],
            "email" => $validatedData["email"],
            "password" => Hash::make($validatedData["password"]),
            "phone_number" => $validatedData["phone_number"],
            "role" => "pelanggan"
        ]);

        Auth::login($user);
        return redirect("/katalog")->with("success", "Registrasi berhasil!");
    }

    public function ProcessLogin(Request $request)
    {
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user?->status_akun === 'nonaktif') {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi admin untuk mendapatkan bantuan.'
                ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $userRole = Auth::user()->role;

            if ($userRole === 'admin' || $userRole === 'karyawan') {
                return redirect()->route('admin.dashboard');
            }

            return redirect('/katalog');
        }

        return back()->withErrors([
            'email' => 'Akses Ditolak! Email atau password tidak cocok dengan sistem kami.'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function profilPelanggan(){
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

        if (!empty($validatedData['password'])) {
            $pelanggan->password = Hash::make($validatedData['password']);
        }

        $pelanggan->save();

        return redirect()
            ->route('pelanggan.profil')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
