<x-app-layout>
    <div class="py-10 max-w-xl mx-auto">

        <div class="bg-white shadow rounded-lg p-6">

            <!-- Judul -->
            <h2 class="text-lg font-semibold text-gray-800 mb-6">
                {{ isset($aset) ? '✏️ Edit Aset' : '➕ Tambah Aset' }}
            </h2>

            <form method="POST"
                action="{{ isset($aset) ? route('admin.aset.update', $aset) : route('admin.aset.store') }}"
                class="space-y-4">

                @csrf
                @isset($aset)
                    @method('PUT')
                @endisset

                <!-- Kode Aset -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kode Aset
                    </label>
                    <input name="kode_aset"
                        class="w-full border rounded-md p-2 focus:ring focus:ring-blue-200"
                        placeholder="Contoh: AST-001"
                        value="{{ old('kode_aset', $aset->kode_aset ?? '') }}">
                </div>

                <!-- Nama Aset -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Aset
                    </label>
                    <input name="nama_aset"
                        class="w-full border rounded-md p-2 focus:ring focus:ring-blue-200"
                        placeholder="Contoh: Laptop Asus"
                        value="{{ old('nama_aset', $aset->nama_aset ?? '') }}">
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kategori Aset
                    </label>
                    <input name="kategori_aset"
                        class="w-full border rounded-md p-2 focus:ring focus:ring-blue-200"
                        placeholder="Contoh: Elektronik"
                        value="{{ old('kategori_aset', $aset->kategori_aset ?? '') }}">
                </div>

                <!-- Kondisi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kondisi Aset
                    </label>
                    <select name="kondisi_aset"
                        class="w-full border rounded-md p-2 focus:ring focus:ring-blue-200">
                        <option value="baik"
                            @selected(old('kondisi_aset', $aset->kondisi_aset ?? '') == 'baik')>
                            Baik
                        </option>
                        <option value="rusak"
                            @selected(old('kondisi_aset', $aset->kondisi_aset ?? '') == 'rusak')>
                            Rusak
                        </option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Status Aset
                    </label>
                    <select name="status_aset"
                        class="w-full border rounded-md p-2 focus:ring focus:ring-blue-200">
                        <option value="tersedia"
                            @selected(old('status_aset', $aset->status_aset ?? '') == 'tersedia')>
                            Tersedia
                        </option>
                        <option value="digunakan"
                            @selected(old('status_aset', $aset->status_aset ?? '') == 'digunakan')>
                            Digunakan
                        </option>
                        <option value="rusak"
                            @selected(old('status_aset', $aset->status_aset ?? '') == 'rusak')>
                            Rusak
                        </option>
                    </select>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end gap-3 pt-4 border-t">

                    <!-- Kembali -->
                    <a href="{{ route('admin.aset.index') }}"
                        class="px-4 py-2 rounded-md bg-gray-100 text-gray-700
                               hover:bg-gray-200 transition">
                        ← Kembali
                    </a>

                    <!-- Simpan -->
                    <button type="submit"
                        class="px-4 py-2 rounded-md bg-green-600 text-white
                               hover:bg-green-700 transition">
                        💾 Simpan
                    </button>

                </div>

            </form>
        </div>

    </div>
</x-app-layout>
