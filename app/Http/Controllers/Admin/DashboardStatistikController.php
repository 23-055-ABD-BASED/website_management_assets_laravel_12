<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Aset;
use App\Models\Peminjaman;
use Carbon\Carbon;

class DashboardStatistikController extends Controller
{
    public function index()
    {
        // ===============================
        // TOTAL DATA
        // ===============================
        $total = [
            'user'       => User::count(),
            'pegawai'    => Pegawai::count(),
            'aset'       => Aset::count(),
            'peminjaman' => Peminjaman::count(),
        ];

        // ===============================
        // GROWTH (PAKAI METHOD YANG ADA)
        // ===============================
        $growth = [
            'user'       => $this->getGrowthOld(User::class),
            'pegawai'    => $this->getGrowthOld(Pegawai::class),
            'aset'       => $this->getGrowthOld(Aset::class),
            'peminjaman' => $this->getGrowthOld(Peminjaman::class),
        ];

        // ===============================
        // STAT UNTUK CARD DASHBOARD
        // ===============================
        $stats = [
            'pegawai' => $growth['pegawai'],
            'user'    => $growth['user'],
            'aset'    => $growth['aset'],
            'pending_request' => Peminjaman::where('status', 'pending')->count(),
        ];

        // ===============================
        // DATA TAMBAHAN DASHBOARD
        // ===============================
        $peminjamanBulanan = Peminjaman::selectRaw('MONTH(created_at) as bulan')
            ->selectRaw('COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $topPeminjam = Peminjaman::select('id_pegawai')
            ->selectRaw('COUNT(*) as total')
            ->whereYear('tanggal_pinjam', now()->year)
            ->whereHas('pegawai', function ($q) {
                $q->where('status_pegawai', 'aktif');
            })
            ->groupBy('id_pegawai')
            ->with('pegawai')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $peminjamanTrend = Peminjaman::selectRaw('YEAR(created_at) as tahun')
            ->selectRaw('MONTH(created_at) as bulan')
            ->selectRaw('COUNT(*) as total')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        $assetHealth = [
            'tersedia'  => Aset::where('status_aset', 'tersedia')->count(),
            'digunakan' => Aset::where('status_aset', 'digunakan')->count(),
            'rusak'     => Aset::where('status_aset', 'rusak')->count(),
        ];

        $rataDurasiPinjam = round(
            Peminjaman::whereNotNull('tanggal_kembali_real')
                ->selectRaw('AVG(DATEDIFF(tanggal_kembali_real, tanggal_pinjam))')
                ->value('AVG(DATEDIFF(tanggal_kembali_real, tanggal_pinjam))')
        ) ?? 0;

        $pegawaiAktif = Pegawai::where('status_pegawai', 'aktif')->count();
        $pegawaiTidakAktif = Pegawai::where('status_pegawai', 'nonaktif')->count();

        $totalDisetujui = Peminjaman::where('status', 'disetujui')->count();
        $terlambat = Peminjaman::where('status', 'disetujui')
            ->whereColumn('tanggal_kembali_real', '>', 'tanggal_kembali')
            ->count();

        $tingkatKeterlambatan = $totalDisetujui > 0
            ? round(($terlambat / $totalDisetujui) * 100, 1)
            : 0;

        $latestPegawai = Pegawai::latest()->take(5)->get();
        $latestAset    = Aset::latest()->take(5)->get();

        $stokKategori = Aset::select('kategori_aset')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(status_aset = "tersedia") as tersedia')
            ->groupBy('kategori_aset')
            ->get();

        $incomingRequests = Peminjaman::with(['pegawai', 'aset'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $peminjamanTerlambat = Peminjaman::with(['pegawai', 'aset'])
            ->where('status', 'disetujui')
            ->whereNull('tanggal_kembali_real')
            ->where('tanggal_kembali', '<', now())
            ->get();

        $users = User::where('role', '!=', 'admin')
            ->doesntHave('pegawai')
            ->get();

        return view('admin.dashboard', compact(
            'total',
            'growth',
            'stats',
            'peminjamanBulanan',
            'topPeminjam',
            'peminjamanTrend',
            'assetHealth',
            'rataDurasiPinjam',
            'pegawaiAktif',
            'pegawaiTidakAktif',
            'tingkatKeterlambatan',
            'latestPegawai',
            'latestAset',
            'stokKategori',
            'incomingRequests',
            'peminjamanTerlambat',
            'users'
        ));
    }

    // ===============================
    // HELPER HITUNG PERTUMBUHAN
    // ===============================
    private function getGrowthOld($model)
    {
        $now = Carbon::now();

        $currentMonth = $model::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        $lastMonth = $model::whereMonth('created_at', $now->copy()->subMonth()->month)
            ->whereYear('created_at', $now->copy()->subMonth()->year)
            ->count();

        $diff = $currentMonth - $lastMonth;

        $percentage = $lastMonth > 0
            ? round(($diff / $lastMonth) * 100, 1)
            : ($currentMonth > 0 ? 100 : 0);

        return [
            'total'       => $model::count(),
            'diff'        => $diff,
            'percentage'  => $percentage,
            'is_positive' => $diff >= 0
        ];
    }
}
