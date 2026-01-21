<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AsetController extends Controller
{
    public function index(Request $request)
    {
        // 1. Inisialisasi Query
        $query = Aset::query();

        // 2. Filter Pencarian (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_aset', 'LIKE', "%$search%")
                  ->orWhere('kode_aset', 'LIKE', "%$search%");
            });
        }

        // 3. Filter Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_aset', $request->kategori);
        }

        // 4. Filter Status
        if ($request->filled('status')) {
            $query->where('status_aset', $request->status);
        }

        // 5. Filter Kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi_aset', $request->kondisi);
        }

        // 6. Ambil SEMUA data (Tanpa Pagination sesuai request)
        $aset = $query->latest()->get();

        // 7. Data untuk Dropdown Filter Kategori (Mengambil unik dari database)
        $kategoriList = Aset::select('kategori_aset')->distinct()->pluck('kategori_aset');

        // 8. Hitung Statistik untuk Header Dashboard
        $stats = [
            'total'     => Aset::count(),
            'tersedia'  => Aset::where('status_aset', 'tersedia')->count(),
            'rusak'     => Aset::where('kondisi_aset', 'rusak')->count(),
        ];

        return view('admin.aset.index', compact('aset', 'stats', 'kategoriList'));
    }

    public function create()
    {
        return view('admin.aset.form');
    }

    public function store(Request $request)
    {
        // Validasi awal
        $request->validate(
            [
                'kode_aset_suffix' => ['required', 'digits:4'],
                'nama_aset'       => ['required'],
                'kategori_aset'   => ['required'],
                'kondisi_aset'    => ['required', 'in:baik,rusak'],
                'status_aset'     => ['required', 'in:tersedia,digunakan,rusak'],
            ]
        );

        // Gabungkan kode aset
        $kodeAset = 'AST-2026-' . $request->kode_aset_suffix;

        // 🔴 CEK DUPLIKAT
        if (Aset::where('kode_aset', $kodeAset)->exists()) {
            return back()
                ->withErrors([
                    'kode_aset' => 'Kode aset sudah digunakan, silakan gunakan kode lain.'
                ])
                ->withInput();
        }

        // Simpan ke database
        Aset::create([
            'kode_aset'     => $kodeAset,
            'nama_aset'     => $request->nama_aset,
            'kategori_aset' => $request->kategori_aset,
            'kondisi_aset'  => $request->kondisi_aset,
            'status_aset'   => $request->status_aset,
        ]);

        return redirect()
            ->route('admin.aset.index')
            ->with('success', 'Aset berhasil ditambahkan');
}


    public function edit(Aset $aset)
    {
        return view('admin.aset.form', compact('aset'));
    }

    public function update(Request $request, Aset $aset)
    {
        // Validasi
        $request->validate([
            'kode_aset_suffix' => ['required', 'digits:4'],
            'nama_aset'       => ['required'],
            'kategori_aset'   => ['required'],
            'kondisi_aset'    => ['required', 'in:baik,rusak'],
            'status_aset'     => ['required', 'in:tersedia,digunakan,rusak'],
        ]);

        // Generate ulang kode aset (jika suffix berubah)
        $tahun = date('Y'); 
        $kodeAset = "AST-{$tahun}-" . $request->kode_aset_suffix;

        // Cek unique manual (kecuali punya diri sendiri)
        if(Aset::where('kode_aset', $kodeAset)->where('id_aset', '!=', $aset->id_aset)->exists()){
             return back()->withErrors(['kode_aset_suffix' => 'Kode aset ini sudah digunakan aset lain.'])->withInput();
        }

        $kodeSudahAda = Aset::where('kode_aset', $kodeAset)
            ->where('id_aset', '!=', $aset->id_aset)
            ->exists();

        if ($kodeSudahAda) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'kode_aset' => 'Kode aset sudah digunakan oleh aset lain.',
                ]);
        }


        // Update database
        $aset->update([
            'kode_aset'     => $kodeAset,
            'nama_aset'     => $request->nama_aset,
            'kategori_aset' => $request->kategori_aset,
            'kondisi_aset'  => $request->kondisi_aset,
            'status_aset'   => $request->status_aset,
        ]);

        return redirect()
            ->route('admin.aset.index')
            ->with('success', 'Aset berhasil diperbarui');
    }

    public function destroy(Aset $aset)
    {
        $aset->delete();
        return back()->with('success', 'Aset berhasil dihapus');
    }
}