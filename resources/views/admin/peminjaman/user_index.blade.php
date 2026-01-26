<x-app-layout>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<<<<<<< HEAD
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    
                    @if($riwayat->isEmpty())
                        <div class="text-center py-16">
                            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum ada riwayat</h3>
                            <p class="mt-1 text-sm text-gray-500">Anda belum pernah mengajukan peminjaman aset apapun.</p>
                            <div class="mt-6">
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                    </svg>
                                    Ajukan Sekarang
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pengajuan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($riwayat as $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $item->aset->nama_aset }}</div>
                                                    <div class="text-xs text-gray-500">Kode: {{ $item->aset->kode_aset }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M') }} - {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->diffInDays(\Carbon\Carbon::parse($item->tanggal_kembali)) + 1 }} Hari
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600 truncate max-w-xs" title="{{ $item->alasan }}">
                                                {{ Str::limit($item->alasan, 40) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset
                                                @if($item->status == 'pending') bg-yellow-50 text-yellow-800 ring-yellow-600/20
                                                @elseif($item->status == 'disetujui') bg-green-50 text-green-700 ring-green-600/20
                                                @elseif($item->status == 'ditolak') bg-red-50 text-red-700 ring-red-600/10
                                                @else bg-gray-50 text-gray-600 ring-gray-500/10 @endif">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $item->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4 border-t border-gray-100 pt-4">
                            {{ $riwayat->links() }}
                        </div>
                    @endif
=======
    {{-- HEADER --}}
    <section class="relative bg-[#171717] pt-14 pb-32 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-br from-[#fd2800]/20 via-transparent to-transparent"></div>
            <div class="absolute -right-24 -bottom-24 w-96 h-96 bg-[#fd2800]/10 blur-3xl rounded-full"></div>
        </div>
>>>>>>> 9fea42ce9e7c560d54a5eb452a414442cd3e1104

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
