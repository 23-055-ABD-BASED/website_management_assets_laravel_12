<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Rules\NipValid; // Pastikan rule ini ada di App/Rules

class PegawaiController extends Controller
{
    /**
     * Menampilkan daftar semua pegawai.
     */
    public function index()
{
    // 1. Data untuk Tabel Pegawai
    $pegawais = Pegawai::with('user')->latest()->paginate(10);
    
    // 2. Data untuk Dropdown di Pop-up (User non-admin & belum jadi pegawai)
    $users = User::where('role', '!=', 'admin')
                 ->doesntHave('pegawai')
                 ->get();

    return view('pegawai.index', compact('pegawais', 'users'));
}

    /**
     * Menampilkan form tambah pegawai (Hanya untuk User yang belum punya data).
     */
    public function create()
    {
        $userId = Auth::id();

        // 1. CEK DUPLIKASI: Apakah user ini sudah punya data pegawai?
        $existingPegawai = Pegawai::where('id_pengguna', $userId)->first();

        if ($existingPegawai) {
            // Jika user admin, mungkin redirect ke index. Jika user biasa, ke dashboard.
            $route = Auth::user()->role === 'admin' ? 'pegawai.index' : 'dashboard';
            
            return redirect()->route($route)
                ->with('error', 'Anda sudah melengkapi data pegawai. Silakan edit data yang ada jika ingin melakukan perubahan.');
        }

        // 2. TAMPILKAN VIEW
        return view('pegawai.create'); 
    }

    /**
     * Menyimpan data pegawai baru ke database.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();

        // 1. Cek Duplikasi (Double Protection)
        if (Pegawai::where('id_pengguna', $userId)->exists()) {
            return redirect()->back()->with('error', 'Akun Anda sudah terdaftar sebagai pegawai.');
        }

        // 2. VALIDASI INPUT
        // Kita menghapus 'status_pegawai' dari validasi agar tidak error karena tidak ada inputnya di form
        $validated = $request->validate([
            'nip_pegawai' => [
                'required',
                'string',
                'unique:pegawai,nip_pegawai',
                new NipValid()
            ],
            'nama_pegawai'   => 'required|string|max:255',
            'bidang_kerja'   => 'required|string|max:255',
            'jabatan'        => 'required|string|max:255',
        ]);

        // 3. SIMPAN DATA
        Pegawai::create([
            'nip_pegawai'    => $validated['nip_pegawai'],
            'nama_pegawai'   => $validated['nama_pegawai'],
            'bidang_kerja'   => $validated['bidang_kerja'],
            'jabatan'        => $validated['jabatan'],            
            'status_pegawai' => 'aktif', 
            
            'id_pengguna'    => $userId,
        ]);

        // 4. REDIRECT BERDASARKAN ROLE
        if (Auth::user()->role === 'admin') {
            return redirect()->route('pegawai.index')
                ->with('success', 'Data pegawai berhasil disimpan.');
        } else {
            return redirect()->route('dashboard')
                ->with('success', 'Selamat! Data kepegawaian Anda berhasil didaftarkan.');
        }
    }

    /**
     * Menampilkan form edit pegawai.
     */
    public function edit(Pegawai $pegawai)
    {
        // OPSIONAL: Proteksi agar user A tidak bisa edit punya user B (kecuali admin)
        if (Auth::user()->role !== 'admin' && $pegawai->id_pengguna !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('pegawai.edit', compact('pegawai'));
    }

    /**
     * Memperbarui data pegawai.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        // OPSIONAL: Proteksi update
        if (Auth::user()->role !== 'admin' && $pegawai->id_pengguna !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nip_pegawai' => [
                'required',
                // Ignore unique check untuk pegawai yang sedang diedit ini
                Rule::unique('pegawai', 'nip_pegawai')->ignore($pegawai->id_pegawai, 'id_pegawai'),
                new NipValid()
            ],
            'nama_pegawai'   => 'required|string|max:255',
            'bidang_kerja'   => 'required|string|max:255',
            'jabatan'        => 'required|string|max:255',
            'status_pegawai' => 'required|in:aktif,nonaktif',
        ]);

        // Update data
        $pegawai->update([
            'nip_pegawai'    => $validated['nip_pegawai'],
            'nama_pegawai'   => $validated['nama_pegawai'],
            'bidang_kerja'   => $validated['bidang_kerja'],
            'jabatan'        => $validated['jabatan'],
            'status_pegawai' => $validated['status_pegawai'],
        ]);

        // Redirect Logic untuk Update
        if (Auth::user()->role === 'admin') {
            return redirect()->route('pegawai.index')
                ->with('success', 'Data pegawai berhasil diperbarui.');
        } else {
            // Jika user biasa update profilnya sendiri (jika diizinkan)
            return redirect()->route('dashboard') // atau route('pegawai.edit', $pegawai->id)
                ->with('success', 'Data profil Anda berhasil diperbarui.');
        }
    }

    /**
     * Menghapus data pegawai.
     */
    public function destroy(Pegawai $pegawai)
    {
        // Hanya admin yang boleh menghapus
        if (Auth::user()->role !== 'admin') { 
            abort(403, 'Hanya admin yang dapat menghapus data.'); 
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil dihapus.');
    }
}