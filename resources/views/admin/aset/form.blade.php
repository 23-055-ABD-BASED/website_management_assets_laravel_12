@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-semibold mb-6">
        {{ isset($aset) ? 'Edit Aset' : 'Tambah Aset' }}
    </h2>

    <form
        method="POST"
        action="{{ isset($aset) ? route('admin.aset.update', $aset->id_aset) : route('admin.aset.store') }}"
    >
        @csrf
        @if(isset($aset))
            @method('PUT')
        @endif

        <!-- KODE ASET (SUFFIX) -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Kode Aset (4 digit)
            </label>
            <input
                type="text"
                name="kode_aset_suffix"
                value="{{ old('kode_aset_suffix', isset($aset) ? substr($aset->kode_aset, -4) : '') }}"
                class="w-full border rounded p-2"
                placeholder="0001"
                required
            >
            @error('kode_aset_suffix')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- NAMA ASET -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Nama Aset
            </label>
            <input
                type="text"
                name="nama_aset"
                value="{{ old('nama_aset', $aset->nama_aset ?? '') }}"
                class="w-full border rounded p-2"
                required
            >
            @error('nama_aset')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- KATEGORI -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Kategori Aset
            </label>
            <select
                name="kategori_aset"
                class="w-full border rounded p-2"
                required
            >
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoriList as $kategori)
                    <option
                        value="{{ $kategori }}"
                        @selected(old('kategori_aset', $aset->kategori_aset ?? '') === $kategori)
                    >
                        {{ $kategori }}
                    </option>
                @endforeach
            </select>
            @error('kategori_aset')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- KONDISI -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Kondisi Aset
            </label>
            <select
                name="kondisi_aset"
                class="w-full border rounded p-2"
                required
            >
                <option value="">-- Pilih Kondisi --</option>
                <option value="baik" @selected(old('kondisi_aset', $aset->kondisi_aset ?? '') === 'baik')>
                    Baik
                </option>
                <option value="rusak" @selected(old('kondisi_aset', $aset->kondisi_aset ?? '') === 'rusak')>
                    Rusak
                </option>
            </select>
            @error('kondisi_aset')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- STATUS -->
        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">
                Status Aset
            </label>
            <select
                name="status_aset"
                class="w-full border rounded p-2"
                required
            >
                <option value="">-- Pilih Status --</option>
                <option value="tersedia" @selected(old('status_aset', $aset->status_aset ?? '') === 'tersedia')>
                    Tersedia
                </option>
                <option value="digunakan" @selected(old('status_aset', $aset->status_aset ?? '') === 'digunakan')>
                    Digunakan
                </option>
                <option value="rusak" @selected(old('status_aset', $aset->status_aset ?? '') === 'rusak')>
                    Rusak
                </option>
            </select>

            <p class="text-xs text-gray-500 mt-1">
                * Aset rusak tidak boleh berstatus tersedia
            </p>

            @error('status_aset')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- ACTION -->
        <div class="flex gap-3">
            <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            >
                {{ isset($aset) ? 'Update' : 'Simpan' }}
            </button>

            <a
                href="{{ route('admin.aset.index') }}"
                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
            >
                Batal
            </a>
        </div>

    </form>
</div>
@endsection
