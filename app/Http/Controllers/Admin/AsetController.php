<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use Illuminate\Http\Request;

class AsetController extends Controller
{
    public function index()
    {
        $aset = Aset::latest()->get();
        return view('admin.aset.index', compact('aset'));
    }

    public function create()
    {
        return view('admin.aset.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_aset' => 'required|unique:aset',
            'nama_aset' => 'required',
            'kategori_aset' => 'required',
            'kondisi_aset' => 'required|in:baik,rusak',
            'status_aset' => 'required|in:tersedia,digunakan,rusak',
        ]);

        Aset::create($request->all());

        return redirect()->route('admin.aset.index')
            ->with('success', 'Aset berhasil ditambahkan');
    }

    public function edit(Aset $aset)
    {
        return view('admin.aset.form', compact('aset'));
    }

    public function update(Request $request, Aset $aset)
    {
        $request->validate([
            'nama_aset' => 'required',
            'kategori_aset' => 'required',
            'kondisi_aset' => 'required',
            'status_aset' => 'required',
        ]);

        $aset->update($request->all());

        return redirect()->route('admin.aset.index')
            ->with('success', 'Aset berhasil diperbarui');
    }

    public function destroy(Aset $aset)
    {
        $aset->delete();
        return back()->with('success', 'Aset berhasil dihapus');
    }
}
