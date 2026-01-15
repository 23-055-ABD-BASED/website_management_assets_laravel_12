<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aset;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


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
        // Validasi
        $request->validate(
        [
            'kode_aset_suffix' => ['required', 'digits:4'],
            'nama_aset'       => ['required'],
            'kategori_aset' => ['required', Rule::in([
                'Elektronik',
                'Furniture',
                'Kendaraan',
                'Peralatan Kantor',
                'Inventaris IT',
            ])],
            'kondisi_aset'    => ['required', 'in:baik,rusak'],
            'status_aset'     => ['required', 'in:tersedia,digunakan,rusak'],
        ],
        [
            'kode_aset_suffix.required' => 'Kode aset wajib diisi.',
            'kode_aset_suffix.digits'   => 'Kode aset harus tepat 4 angka.',
        ]
    );

        // Gabungkan kode aset
        $kodeAset = 'AST-2026-' . $request->kode_aset_suffix;

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
            'kode_aset_suffix' => ['required', 'digits_between:1,4'],
            'nama_aset'       => ['required'],
            'kategori_aset'   => ['required'],
            'kondisi_aset'    => ['required', 'in:baik,rusak'],
            'status_aset'     => ['required', 'in:tersedia,digunakan,rusak'],
        ]);

        // Gabungkan ulang kode aset
        $kodeAset = 'AST-2026-' . str_pad(
            $request->kode_aset_suffix,
            4,
            '0',
            STR_PAD_LEFT
        );

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
