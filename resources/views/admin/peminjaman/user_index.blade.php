<x-app-layout>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- HEADER --}}
   <section class="relative bg-[#171717] pt-24 pb-32 sm:pt-32 sm:pb-40 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-br from-[#fd2800]/20 via-transparent to-transparent"></div>
        <div class="absolute -right-24 -bottom-12 w-64 h-64 sm:w-96 sm:h-96 bg-[#fd2800]/10 blur-3xl rounded-full"></div>
    </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <h1 class="flex items-center gap-3 text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
                        <span class="w-1.5 h-8 bg-[#fd2800] rounded-full"></span>
                        Riwayat Peminjaman
                    </h1>
                    <p class="mt-2 text-xs sm:text-sm text-white/60">
                        Pantau status dan histori peminjaman aset Anda.
                    </p>
                </div>

                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-lg bg-white/10 px-4 py-2.5 text-sm font-semibold text-white
                          ring-1 ring-white/10 hover:bg-white hover:text-[#171717] transition w-full sm:w-auto">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd"/>
                    </svg>
                    Dashboard
                </a>
            </div>
        </div>
    </section>

    {{-- CONTENT --}}
    <section class="-mt-16 relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16"
             x-data="{ show: false }"
             x-init="setTimeout(() => show = true, 100)">
        
        <div x-show="show"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-y-8"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-[#ededed] rounded-2xl shadow-xl border border-gray-200 overflow-hidden">

            <div class="p-4 sm:p-8">

                @if($riwayat->isEmpty())
                    {{-- EMPTY STATE --}}
                    <div class="py-16 sm:py-20 text-center">
                        <div class="mx-auto w-16 h-16 sm:w-20 sm:h-20 flex items-center justify-center rounded-full bg-gray-200 mb-6">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-[#171717]">Belum Ada Riwayat</h3>
                        <p class="mt-2 text-sm text-gray-500 px-4">Anda belum pernah mengajukan peminjaman aset.</p>
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center gap-2 mt-8 rounded-lg bg-[#fd2800] px-6 py-3 text-sm font-bold text-white hover:bg-[#d62200] transition">
                            Ajukan Sekarang
                        </a>
                    </div>
                @else

                    {{-- DESKTOP TABLE (Hidden on Mobile) --}}
                    <div class="hidden md:block overflow-x-auto rounded-xl border border-gray-200">
                        <table class="min-w-full text-sm">
                            <thead class="bg-[#171717] text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Aset</th>
                                    <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Durasi</th>
                                    <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Keperluan</th>
                                    <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Diajukan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-[#ededed]">
                                @foreach($riwayat as $item)
                                    <tr class="hover:bg-white transition">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-[#171717]">{{ $item->aset->nama_aset }}</div>
                                            <div class="text-xs text-gray-500">{{ $item->aset->kode_aset }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-[#171717]">
                                                {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M') }} – {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                                            </div>
                                            @php
                                                $tglKembali = \Carbon\Carbon::parse($item->tanggal_kembali);
                                                $hariIni = \Carbon\Carbon::now()->startOfDay();
                                                $selisih = $hariIni->diffInDays($tglKembali, false);
                                                $map = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'disetujui' => 'bg-green-100 text-green-800',
                                                    'ditolak' => 'bg-red-100 text-red-800',
                                                    'kembali' => 'bg-blue-100 text-blue-800',
                                                ];
                                            @endphp
                                            @if($item->status == 'disetujui')
                                                @if($selisih > 0)
                                                    <div class="text-[10px] text-green-600 font-bold uppercase">Sisa {{ $selisih }} Hari</div>
                                                @elseif($selisih == 0)
                                                    <div class="text-[10px] text-orange-500 font-bold uppercase">Terakhir Hari Ini!</div>
                                                @else
                                                    <div class="text-[10px] text-red-600 font-bold uppercase">Terlambat {{ abs($selisih) }} Hari</div>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 italic max-w-xs truncate">
                                            "{{ $item->alasan ?: 'Tidak ada keterangan' }}"
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold {{ $map[$item->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-xs text-gray-500 whitespace-nowrap">
                                            {{ $item->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- MOBILE CARDS (Hidden on Desktop) --}}
                    <div class="md:hidden space-y-4">
                        @foreach($riwayat as $item)
                            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="font-bold text-[#171717] text-base leading-tight">
                                            {{ $item->aset->nama_aset }}
                                        </h4>
                                        <span class="text-[10px] text-[#fd2800] font-mono font-bold uppercase tracking-wider">
                                            {{ $item->aset->kode_aset }}
                                        </span>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold {{ $map[$item->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </div>

                                <div class="space-y-3 text-sm">
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M') }} – {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</span>
                                    </div>

                                    <div class="p-3 bg-gray-50 rounded-lg border-l-4 border-gray-300">
                                        <p class="text-xs text-gray-500 italic leading-relaxed">
                                            "{{ $item->alasan ?: 'Tidak ada keterangan' }}"
                                        </p>
                                    </div>

                                    <div class="flex justify-between items-center pt-2 border-t border-gray-50">
                                        <span class="text-[10px] text-gray-400 uppercase font-medium">Diajukan {{ $item->created_at->diffForHumans() }}</span>
                                        
                                        @if($item->status == 'disetujui')
                                            @php
                                                $tglKembali = \Carbon\Carbon::parse($item->tanggal_kembali);
                                                $selisih = \Carbon\Carbon::now()->startOfDay()->diffInDays($tglKembali, false);
                                            @endphp
                                            <span class="text-[10px] font-bold {{ $selisih < 0 ? 'text-red-600' : 'text-green-600' }}">
                                                @if($selisih > 0) Sisa {{ $selisih }} Hari @elseif($selisih == 0) Hari Ini! @else Terlambat {{ abs($selisih) }} Hari @endif
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- PAGINATION --}}
                    <div class="mt-8">
                        {{ $riwayat->links() }}
                    </div>

                @endif
            </div>
        </div>
    </section>
</x-app-layout>