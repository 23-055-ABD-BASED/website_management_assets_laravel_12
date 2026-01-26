<x-app-layout>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- HEADER --}}
    <section class="relative bg-[#171717] pt-14 pb-32 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-br from-[#fd2800]/20 via-transparent to-transparent"></div>
            <div class="absolute -right-24 -bottom-24 w-96 h-96 bg-[#fd2800]/10 blur-3xl rounded-full"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="flex items-center gap-3 text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                        <span class="w-1.5 h-8 bg-[#fd2800] rounded-full"></span>
                        Riwayat Peminjaman
                    </h1>
                    <p class="mt-2 text-sm text-white/60">
                        Pantau status dan histori peminjaman aset Anda.
                    </p>
                </div>

                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-white/10 px-4 py-2 text-sm font-semibold text-white
                          ring-1 ring-white/10 hover:bg-white hover:text-[#171717] transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z"
                              clip-rule="evenodd"/>
                    </svg>
                    Dashboard
                </a>
            </div>
        </div>
    </section>

    {{-- CONTENT --}}
    <section class="-mt-24 relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16"
             x-data="{ show: false }"
             x-init="setTimeout(() => show = true, 100)">
        <div
            x-show="show"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-8"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="bg-[#ededed] rounded-2xl shadow-xl border border-gray-200 overflow-hidden">

            <div class="p-6 sm:p-8">

                {{-- EMPTY STATE --}}
                @if($riwayat->isEmpty())
                    <div class="py-20 text-center">
                        <div class="mx-auto w-20 h-20 flex items-center justify-center rounded-full bg-gray-200 mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#171717]">Belum Ada Riwayat</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Anda belum pernah mengajukan peminjaman aset.
                        </p>
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center gap-2 mt-8 rounded-lg bg-[#fd2800] px-6 py-3 text-sm font-bold text-white
                                  hover:bg-[#d62200] transition">
                            Ajukan Sekarang
                        </a>
                    </div>
                @else

                {{-- DESKTOP TABLE --}}
                <div class="hidden md:block overflow-x-auto rounded-xl border border-gray-200">
                    <table class="min-w-full text-sm">
                        <thead class="bg-[#171717] text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold uppercase">Aset</th>
                            <th class="px-6 py-4 text-left font-semibold uppercase">Durasi</th>
                            <th class="px-6 py-4 text-left font-semibold uppercase">Keperluan</th>
                            <th class="px-6 py-4 text-left font-semibold uppercase">Status</th>
                            <th class="px-6 py-4 text-left font-semibold uppercase">Diajukan</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-[#ededed]">
                        @foreach($riwayat as $item)
                            <tr class="hover:bg-white transition">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-[#171717]">
                                        {{ $item->aset->nama_aset }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $item->aset->kode_aset }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-medium text-[#171717]">
                                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M') }}
                                        –
                                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-gray-600 italic max-w-xs truncate">
                                    "{{ $item->alasan }}"
                                </td>

                                <td class="px-6 py-4">
                                    @php
                                        $map = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'disetujui' => 'bg-green-100 text-green-800',
                                            'ditolak' => 'bg-red-100 text-red-800',
                                            'kembali' => 'bg-blue-100 text-blue-800',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $map[$item->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-gray-500">
                                    {{ $item->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- MOBILE CARDS --}}
                <div class="md:hidden space-y-4">
                    @foreach($riwayat as $item)
                        <div class="bg-white rounded-xl p-4 shadow border border-gray-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-[#171717]">
                                        {{ $item->aset->nama_aset }}
                                    </h4>
                                    <span class="text-xs text-[#fd2800] font-mono">
                                        {{ $item->aset->kode_aset }}
                                    </span>
                                </div>
                                <span class="text-xs font-bold px-2 py-1 rounded bg-gray-100">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </div>

                            <div class="mt-3 text-sm space-y-1">
                                <div class="text-gray-600">
                                    <strong>Durasi:</strong>
                                    {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M') }}
                                    –
                                    {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                                </div>
                                <div class="text-gray-500">
                                    {{ $item->created_at->diffForHumans() }}
                                </div>
                                <p class="mt-2 text-gray-500 italic">
                                    "{{ $item->alasan }}"
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- PAGINATION --}}
                <div class="mt-8 flex justify-center">
                    {{ $riwayat->links() }}
                </div>

                @endif
            </div>
        </div>
    </section>
</x-app-layout>
