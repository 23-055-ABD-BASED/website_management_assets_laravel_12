<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">
                        Selamat datang, Admin {{ auth()->user()->username }}!
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Card 1: Total Pegawai -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <h4 class="font-semibold text-blue-900 mb-2">Total Pegawai</h4>
                            <p class="text-3xl font-bold text-blue-600">
                                {{ \App\Models\Pegawai::count() }}
                            </p>
                        </div>

                        <!-- Card 2: Total User -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <h4 class="font-semibold text-green-900 mb-2">Total User</h4>
                            <p class="text-3xl font-bold text-green-600">
                                {{ \App\Models\User::where('role', 'user')->count() }}
                            </p>
                        </div>
                        
                        <!-- Card 3: Total Aset -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                            <h4 class="font-semibold text-yellow-900 mb-2">Total Aset</h4>
                            <p class="text-3xl font-bold text-yellow-600">
                                {{ \App\Models\Aset::count() }}
                            </p>
                        </div>

                        <!-- Card 4: Pegawai Aktif -->
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                            <h4 class="font-semibold text-purple-900 mb-2">Pegawai Aktif</h4>
                            <p class="text-3xl font-bold text-purple-600">
                                {{ \App\Models\Pegawai::where('status_pegawai', 'aktif')->count() }}
                            </p>
                        </div>

                        <!-- Card 5: Pegawai Non-Aktif -->
                        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                            <h4 class="font-semibold text-red-900 mb-2">Pegawai Non-Aktif</h4>
                            <p class="text-3xl font-bold text-red-600">
                                {{ \App\Models\Pegawai::where('status_pegawai', 'nonaktif')->count() }}
                            </p>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="mt-8 p-4 bg-gray-100 rounded-lg">
                        <p class="text-sm text-gray-700">
                            <strong>Note:</strong> Ini adalah dashboard admin yang menampilkan ringkasan data sistem.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
