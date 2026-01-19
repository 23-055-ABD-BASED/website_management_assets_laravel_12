<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="md:flex md:items-center md:justify-between mb-6 px-4 sm:px-0">
                <div class="min-w-0 flex-1">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                        Riwayat Peminjaman Saya
                    </h2>
                </div>
                <div class="mt-4 flex md:ml-4 md:mt-0">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>

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

                </div>
            </div>
        </div>
    </div>
</x-app-layout>