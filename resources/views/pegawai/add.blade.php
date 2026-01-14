<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Pegawai (Admin Mode)</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded-lg">
                
                <form action="{{ route('pegawai.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Pilih Akun User</label>
                        <select name="id_pengguna" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->username }} (Email: {{ $user->email ?? '-' }})</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">*User yang sudah jadi pegawai tidak akan muncul.</p>
                        @error('id_pengguna') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">NIP</label>
                        <input type="text" name="nip_pegawai" value="{{ old('nip_pegawai') }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('nip_pegawai') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai') }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('nama_pegawai') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Jabatan</label>
                            <input type="text" name="jabatan" value="{{ old('jabatan') }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Bidang Kerja</label>
                            <input type="text" name="bidang_kerja" value="{{ old('bidang_kerja') }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-gray-700">Status</label>
                        <select name="status_pegawai" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non-Aktif</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Simpan Data
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>