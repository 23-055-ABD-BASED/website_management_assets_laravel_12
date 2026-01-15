<x-app-layout>
    <div class="py-10 max-w-7xl mx-auto px-4">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">
                📦 Manajemen Aset
            </h2>

            <a href="{{ route('admin.aset.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
                + Tambah Aset
            </a>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Kondisi</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($aset as $a)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3 font-medium">
                                    {{ $a->kode_aset }}
                                </td>
                                <td class="px-6 py-3">
                                    {{ $a->nama_aset }}
                                </td>
                                <td class="px-6 py-3">
                                    {{ $a->kategori_aset }}
                                </td>
                                <td class="px-6 py-3">
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                            @if($a->status_aset == 'tersedia') bg-green-100 text-green-700
                                            @elseif($a->status_aset == 'digunakan') bg-yellow-100 text-yellow-700
                                            @else bg-red-100 text-red-700 @endif">
                                        {{ ucfirst($a->status_aset) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                        @if($a->kondisi_aset == 'baik') bg-blue-100 text-blue-700
                                        @else bg-red-100 text-red-700 @endif">
                                            {{ ucfirst($a->kondisi_aset) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex justify-center gap-2">

                                        <!-- Edit -->
                                        <a href="{{ route('admin.aset.edit', $a) }}" class="inline-flex items-center gap-1 px-3 py-1.5
                          bg-blue-100 text-blue-700
                          rounded-md text-xs font-semibold
                          hover:bg-blue-200 transition">
                                            ✏️ Edit
                                        </a>

                                        <!-- Hapus -->
                                        <form method="POST" action="{{ route('admin.aset.destroy', $a) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus aset ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5
                               bg-red-100 text-red-700
                               rounded-md text-xs font-semibold
                               hover:bg-red-200 transition">
                                                🗑️ Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">
                                Data aset belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>