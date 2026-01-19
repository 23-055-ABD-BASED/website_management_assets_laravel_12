<x-app-layout>
    {{-- SETUP ALPINE JS: showModal --}}
    <div x-data="{ showModal: {{ $errors->any() ? 'true' : 'false' }} }" class="min-h-screen bg-white font-sans text-[#444444] relative overflow-hidden">

        {{-- Background Blobs (Subtle) --}}
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-[#fd2800] opacity-5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-[#171717] opacity-5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            
            <div class="bg-white rounded-3xl border border-[#ededed] shadow-xl shadow-[#ededed]/50 p-4 md:px-6 md:py-4 mb-8 flex flex-col md:flex-row items-center gap-6">
    
            <div class="shrink-0 text-center md:text-left">
                <h1 class="text-2xl font-black text-[#171717] tracking-tight">Data <span class="text-[#fd2800]">Pegawai</span></h1>
                <p class="text-xs text-[#444444] font-medium">Total: {{ $pegawais->total() }} Data</p>
            </div>
            <div class="w-full flex-1 relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-[#444444] group-focus-within:text-[#fd2800] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" 
                    class="block w-full pl-11 pr-4 py-3 rounded-2xl border-none bg-[#fafafa] text-sm text-[#171717] placeholder-[#444444]/50 focus:ring-2 focus:ring-[#fd2800]/20 focus:bg-white transition-all shadow-inner" 
                    placeholder="Cari NIP / Nama Pegawai...">
            </div>

            {{-- 3. RIGHT: Add Button --}}
            <div class="shrink-0 w-full md:w-auto">
                <button @click="showModal = true" class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3 bg-[#171717] hover:bg-[#fd2800] text-white rounded-2xl text-sm font-bold transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah
                </button>
            </div>

        </div>

            {{-- 
                ==========================================
                2. DATA TABLE
                ==========================================
            --}}
            <div class="bg-white rounded-[2rem] border border-[#ededed] shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-[#fafafa] border-b border-[#ededed]">
                                <th class="py-4 pl-8 pr-4 text-left text-xs font-extrabold text-[#171717] uppercase tracking-wider">Identitas</th>
                                <th class="px-4 py-4 text-left text-xs font-extrabold text-[#171717] uppercase tracking-wider">Jabatan & Divisi</th>
                                <th class="px-4 py-4 text-left text-xs font-extrabold text-[#171717] uppercase tracking-wider">Akun</th>
                                <th class="px-4 py-4 text-center text-xs font-extrabold text-[#171717] uppercase tracking-wider">Status</th>
                                <th class="py-4 pl-4 pr-8 text-right text-xs font-extrabold text-[#171717] uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#ededed]">
                            @forelse($pegawais as $pegawai)
                            <tr class="group hover:bg-[#fafafa] transition-colors duration-200">
                                
                                {{-- Identitas --}}
                                <td class="py-4 pl-8 pr-4 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-[#ededed] to-white border border-[#ededed] flex items-center justify-center text-[#fd2800] font-black text-sm shadow-sm">
                                            {{ substr($pegawai->nama_pegawai, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-[#171717] text-sm">{{ $pegawai->nama_pegawai }}</div>
                                            <div class="text-xs font-mono text-[#444444] bg-[#ededed]/50 px-1.5 py-0.5 rounded inline-block mt-0.5">
                                                {{ $pegawai->nip_pegawai }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Jabatan --}}
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="font-bold text-[#444444] text-sm">{{ $pegawai->jabatan }}</div>
                                    <div class="text-xs text-[#444444]/60">{{ $pegawai->bidang_kerja }}</div>
                                </td>

                                {{-- Akun --}}
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if($pegawai->user)
                                        <div class="text-sm font-medium text-[#171717] flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-[#fd2800]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                            {{ $pegawai->user->username }}
                                        </div>
                                    @else
                                        <span class="text-xs text-[#444444]/50 italic">Tidak terhubung</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    @if($pegawai->status_pegawai === 'aktif')
                                        <span class="inline-flex items-center justify-center w-20 py-1 rounded-full text-[10px] font-bold bg-[#171717] text-white tracking-wide uppercase">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center w-20 py-1 rounded-full text-[10px] font-bold bg-[#ededed] text-[#444444] border border-[#d4d4d4] tracking-wide uppercase">
                                            Non-Aktif
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="py-4 pl-4 pr-8 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-1 ">
                                        <a href="{{ route('pegawai.edit', $pegawai->id_pegawai) }}" class="p-2 rounded-lg text-[#444444] hover:bg-[#ededed] hover:text-[#171717] transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form action="{{ route('pegawai.destroy', $pegawai->id_pegawai) }}" method="POST" class="form-delete inline-block">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn-delete p-2 rounded-lg text-[#fd2800] hover:bg-red-50 hover:text-red-700 transition" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-[#fafafa] rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-[#d4d4d4]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                        </div>
                                        <p class="text-sm text-[#444444] font-medium">Belum ada data pegawai.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-[#ededed] bg-[#fafafa]">
                    {{ $pegawais->links() }}
                </div>
            </div>
        </div>

        {{-- 
            ==========================================
            3. MODAL POP-UP (CLEAN)
            ==========================================
        --}}
        <div 
            x-show="showModal" 
            style="display: none;"
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" 
            role="dialog" 
            aria-modal="true"
        >
            <div 
                x-show="showModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-[#171717]/80 backdrop-blur-sm transition-opacity" 
                @click="showModal = false"
            ></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div 
                    x-show="showModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-[#ededed]"
                >
                    {{-- Header --}}
                    <div class="bg-white px-6 py-5 border-b border-[#ededed] flex justify-between items-center">
                        <h3 class="text-lg font-black text-[#171717]">Tambah Pegawai</h3>
                        <button @click="showModal = false" class="text-[#444444] hover:text-[#fd2800] transition">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    {{-- Form --}}
                    <form action="{{ route('pegawai.store') }}" method="POST">
                        @csrf
                        <div class="px-6 py-6 space-y-5">
                            {{-- Pilih User --}}
                            <div>
                                <label class="block text-xs font-bold text-[#171717] uppercase mb-2">Akun User <span class="text-[#fd2800]">*</span></label>
                                <select name="id_pengguna" class="block w-full rounded-xl border-[#ededed] bg-[#fafafa] text-sm text-[#171717] focus:border-[#fd2800] focus:ring-[#fd2800]">
                                    <option value="">-- Pilih Akun --</option>
                                    @if(isset($users))
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('id_pengguna') == $user->id ? 'selected' : '' }}>
                                                {{ $user->username }} ({{ $user->email ?? 'No Email' }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('id_pengguna') <p class="text-[#fd2800] text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>

                            {{-- NIP & Nama --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-[#171717] uppercase mb-2">NIP</label>
                                    <input type="text" name="nip_pegawai" value="{{ old('nip_pegawai') }}" class="block w-full rounded-xl border-[#ededed] bg-[#fafafa] text-sm text-[#171717] focus:border-[#fd2800] focus:ring-[#fd2800]">
                                    @error('nip_pegawai') <p class="text-[#fd2800] text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#171717] uppercase mb-2">Nama Lengkap</label>
                                    <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai') }}" class="block w-full rounded-xl border-[#ededed] bg-[#fafafa] text-sm text-[#171717] focus:border-[#fd2800] focus:ring-[#fd2800]">
                                    @error('nama_pegawai') <p class="text-[#fd2800] text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            {{-- Jabatan & Bidang --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-[#171717] uppercase mb-2">Jabatan</label>
                                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" class="block w-full rounded-xl border-[#ededed] bg-[#fafafa] text-sm text-[#171717] focus:border-[#fd2800] focus:ring-[#fd2800]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#171717] uppercase mb-2">Bidang Kerja</label>
                                    <input type="text" name="bidang_kerja" value="{{ old('bidang_kerja') }}" class="block w-full rounded-xl border-[#ededed] bg-[#fafafa] text-sm text-[#171717] focus:border-[#fd2800] focus:ring-[#fd2800]">
                                </div>
                            </div>

                            {{-- Auto Status --}}
                            <input type="hidden" name="status_pegawai" value="aktif">
                        </div>

                        {{-- Footer --}}
                        <div class="bg-[#fafafa] px-6 py-4 flex flex-row-reverse gap-3 rounded-b-3xl border-t border-[#ededed]">
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-xl bg-[#171717] px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-black/20 hover:bg-[#fd2800] transition-all">
                                Simpan
                            </button>
                            <button @click="showModal = false" type="button" class="w-full sm:w-auto inline-flex justify-center rounded-xl bg-white px-6 py-2.5 text-sm font-bold text-[#444444] shadow-sm border border-[#ededed] hover:bg-[#ededed] transition-all">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>

    {{-- SweetAlert2 Script --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Hapus Konfirmasi
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Data tidak bisa dikembalikan.",
                    icon: 'warning',
                    iconColor: '#fd2800',
                    background: '#ffffff',
                    color: '#171717',
                    showCancelButton: true,
                    confirmButtonColor: '#fd2800',
                    cancelButtonColor: '#171717',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-3xl shadow-2xl',
                        confirmButton: 'rounded-xl px-6 py-2 font-bold',
                        cancelButton: 'rounded-xl px-6 py-2 font-bold'
                    }
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        // Notifikasi Sukses
        @if(session('success'))
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#171717',
                color: '#ffffff',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({ icon: 'success', iconColor: '#fd2800', title: '{{ session("success") }}' })
        @endif
    </script>
</x-app-layout>