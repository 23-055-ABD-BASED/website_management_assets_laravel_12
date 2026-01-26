<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use Illuminate\Http\Request;

class AsetController extends Controller
{
    /**
     * =========================
     * LIST DATA ASET + FILTER
     * =========================
     */
    public function index(Request $request)
    {
        $query = Aset::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_aset', 'LIKE', "%{$search}%")
                  ->orWhere('kode_aset', 'LIKE', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_aset', $request->kategori);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status_aset', $request->status);
        }

        // Filter kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi_aset', $request->kondisi);
        }

        $aset = $query->latest()->get();

        $kategoriList = Aset::select('kategori_aset')
            ->distinct()
            ->pluck('kategori_aset');

        $stats = [
            'total'    => Aset::count(),
            'tersedia' => Aset::where('status_aset', 'tersedia')->count(),
            'rusak'    => Aset::where('kondisi_aset', 'rusak')->count(),
        ];

        return view('admin.aset.index', compact('aset', 'stats', 'kategoriList'));
    }

    /**
     * =========================
     * FORM TAMBAH ASET
     * =========================
     */
    public function create()
    {
        return view('admin.aset.form');
    }

    /**
     * =========================
     * SIMPAN ASET BARU
     * =========================
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_aset_suffix' => ['required', 'digits:4'],
            'nama_aset'        => ['required'],
            'kategori_aset'    => ['required'],
            'kondisi_aset'     => ['required', 'in:baik,rusak'],
            'status_aset'      => ['required', 'in:tersedia,digunakan,rusak'],
        ]);

        $kodeAset = 'AST-2026-' . $request->kode_aset_suffix;

        if (Aset::where('kode_aset', $kodeAset)->exists()) {
            return back()
                ->withErrors(['kode_aset_suffix' => 'Kode aset sudah digunakan.'])
                ->withInput();
        }

        Aset::create([
            'kode_aset'     => $kodeAset,
            'nama_aset'     => $request->nama_aset,
            'kategori_aset' => $request->kategori_aset,
            'kondisi_aset'  => $request->kondisi_aset,
            'status_aset'   => $request->status_aset,
        ]);

        return redirect()
            ->route('admin.aset.index')
            ->with('success', 'Aset berhasil ditambahkan.');
    }

    /**
     * =========================
     * FORM EDIT ASET
     * =========================
     */
    public function edit(Aset $aset)
    {
        if ($aset->status_aset === 'digunakan') {
            return redirect()
                ->route('admin.aset.index')
                ->withErrors(['error' => 'Aset yang sedang digunakan tidak dapat diedit.']);
        }

        return view('admin.aset.form', compact('aset'));
    }

    /**
     * =========================
     * UPDATE ASET
     * =========================
     */
    public function update(Request $request, Aset $aset)
    {
        if ($aset->status_aset === 'digunakan') {
            return redirect()
                ->route('admin.aset.index')
                ->withErrors(['error' => 'Aset yang sedang digunakan tidak dapat diperbarui.']);
        }

        $request->validate([
            'kode_aset_suffix' => ['required', 'digits:4'],
            'nama_aset'        => ['required'],
            'kategori_aset'    => ['required'],
            'kondisi_aset'     => ['required', 'in:baik,rusak'],
            'status_aset'      => ['required', 'in:tersedia,digunakan,rusak'],
        ]);

        $tahun = date('Y');
        $kodeAset = "AST-{$tahun}-" . $request->kode_aset_suffix;

        if (
            Aset::where('kode_aset', $kodeAset)
                ->where('id_aset', '!=', $aset->id_aset)
                ->exists()
        ) {
            return back()
                ->withErrors(['kode_aset_suffix' => 'Kode aset sudah digunakan aset lain.'])
                ->withInput();
        }

        $aset->update([
            'kode_aset'     => $kodeAset,
            'nama_aset'     => $request->nama_aset,
            'kategori_aset' => $request->kategori_aset,
            'kondisi_aset'  => $request->kondisi_aset,
            'status_aset'   => $request->status_aset,
        ]);

        return redirect()
            ->route('admin.aset.index')
            ->with('success', 'Aset berhasil diperbarui.');
    }

    /**
     * =========================
     * HAPUS ASET
     * =========================
     */
    public function destroy(Aset $aset)
    {
        if ($aset->status_aset === 'digunakan') {
            return back()
                ->withErrors(['error' => 'Aset yang sedang digunakan tidak dapat dihapus.']);
        }

        $aset->delete();

        return back()
            ->with('success', 'Aset berhasil dihapus.');
    }
}
