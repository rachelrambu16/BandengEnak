<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    private function authorizeProductManagement()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'karyawan'])) {
            abort(403, "Anda tidak berhak mengakses kelola produk");
        }
    }

    private function authorizeAdminOnly($message = "Anda bukan admin")
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, $message);
        }
    }

    /**
     * Menampilkan semua produk (pencarian difokuskan HANYA pada nama produk & pagination)
     */
    public function index(Request $request)
    {
        $this->authorizeProductManagement();

        $search = $request->input('search');

        // Query produk: pencarian hanya pada kolom 'nama_produk'
        $products = Product::when($search, function ($query, $search) {
                return $query->where('nama_produk', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10); // Menampilkan 10 data per halaman

        return view('admin.kelola_produk', compact('products', 'search'));
    }

    /**
     * Form tambah produk
     */
    public function create()
    {
        $this->authorizeAdminOnly();

        return view("admin.tambah_produk");
    }

    /**
     * Simpan produk baru
     */
    public function store(Request $request)
    {
        $this->authorizeAdminOnly("Anda tidak berhak menambahkan barang");

        if ($request->has('harga')) {
            $request->merge([
                'harga' => str_replace('.', '', $request->harga)
            ]);
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $path = $request->file('gambar')->store('produk', 'public');

        Product::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $path
        ]);

        return redirect()->route('admin.kelola_produk')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Form edit produk
     */
    public function edit($id)
    {
        $this->authorizeProductManagement();

        $product = Product::findOrFail($id);

        return view('admin.edit_produk', compact('product'));
    }

    /**
     * Update produk
     */
    public function update(Request $request, $id)
    {
        $this->authorizeProductManagement();

        if ($request->has('harga')) {
            $request->merge([
                'harga' => str_replace('.', '', $request->harga)
            ]);
        }

        $product = Product::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Jika upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
                Storage::disk('public')->delete($product->gambar);
            }

            $path = $request->file('gambar')->store('produk', 'public');
            $product->gambar = $path;
        }

        $product->update([
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $product->gambar
        ]);

        return redirect()->route('admin.kelola_produk')
            ->with('success', 'Produk berhasil diupdate!');
    }

    /**
     * Hapus produk
     */
    public function destroy($id)
    {
        $this->authorizeAdminOnly();

        $product = Product::findOrFail($id);

        // Hapus gambar
        if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()->route('admin.kelola_produk')
            ->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Daftar Pelanggan
     */
    public function pelanggan()
    {
        $this->authorizeAdminOnly();

        $pelanggan = User::where('role', 'pelanggan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.daftarpelanggan', compact('pelanggan'));
    }

    /**
     * Daftar Karyawan
     */
    public function karyawan()
    {
        $this->authorizeAdminOnly();

        $karyawan = User::where('role', 'karyawan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.kelola_karyawan', compact('karyawan'));
    }
    
    //edit profil karyawan (form) 
    public function editKaryawan($id)
    {
        if (!Auth::check()) {
            abort(403, 'Silakan login terlebih dahulu.');
        }

        if (Auth::user()->role === 'admin') {
            $karyawan = User::where('role', 'karyawan')->findOrFail($id);
        } elseif (Auth::user()->role === 'karyawan') {
            if (Auth::id() != $id) {
                abort(403, 'Anda hanya dapat mengedit profil sendiri.');
            }
            $karyawan = User::where('role', 'karyawan')->findOrFail($id);
        } else {
            abort(403, 'Anda tidak berhak mengakses halaman ini.');
        }

        return view('admin.edit_karyawan', compact('karyawan'));
    }

    //update karyawan (request)
    public function updateKaryawan(Request $request, $id)
    {
        if (!Auth::check()) {
            abort(403, 'Silakan login terlebih dahulu.');
        }

        if (Auth::user()->role === 'admin') {
            $karyawan = User::where('role', 'karyawan')->findOrFail($id);
        } elseif (Auth::user()->role === 'karyawan') {
            if (Auth::id() != $id) {
                abort(403, 'Anda hanya dapat mengedit profil sendiri.');
            }
            $karyawan = User::where('role', 'karyawan')->findOrFail($id);
        } else {
            abort(403, 'Anda tidak berhak mengubah profil ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone_number' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
        ]);

        $karyawan->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'alamat' => $request->alamat,
        ]);

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.karyawan')->with('success', 'Profil karyawan berhasil diperbarui!');
        }
        
        return redirect()->route('karyawan.profil')->with('success', 'Profil Anda berhasil diperbarui!');
    }

    //tambah akun karyawan
    public function createKaryawan()
    {
        $this->authorizeAdminOnly();
        return view('admin.tambah_karyawan');
    }

    public function storeKaryawan(Request $request)
    {
        $this->authorizeAdminOnly();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone_number' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'alamat' => $request->alamat,
            'password' => $request->password,
            'role' => 'karyawan',
        ]);

        return redirect()->route('admin.karyawan')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    //hapus akun karyawan
    public function destroyKaryawan($id)
    {
        $this->authorizeAdminOnly();
        $karyawan = User::where('role', 'karyawan')->findOrFail($id);
        $karyawan->delete();
        
        return redirect()->route('admin.karyawan')->with('success', 'Profil karyawan berhasil dihapus!');
    }

    //lihat profil karyawan 
    public function showKaryawan($id)
    {
        $this->authorizeAdminOnly();
        $karyawan = User::where('role', 'karyawan')->findOrFail($id);
        
        return view('admin.profil_karyawan', compact('karyawan'));
    }

    //untuk karyawan
    public function profilKaryawan()
    {
        if (!Auth::check()) {
            abort(403, 'Silakan login terlebih dahulu.');
        }

        if (Auth::user()->role === 'karyawan') {
            $karyawan = Auth::user();
        } elseif (Auth::user()->role === 'admin') {
            return redirect()->route('admin.karyawan');
        } else {
            abort(403, 'Anda tidak berhak mengakses halaman ini.');
        }

        return view('admin.profil_karyawan', compact('karyawan'));
    }
}