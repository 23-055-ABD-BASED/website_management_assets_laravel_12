<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Peminjaman;
use App\Models\Aset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller
{
    // --- FITUR UNTUK USER (PEGAWAI) ---

    // 1. Simpan Pengajuan
    public function store(Request $request)
    {
        $request->validate([
            'id_aset' => 'required|exists:aset,id_aset',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'alasan' => 'required|string',
        ]);

        // Pastikan aset tersedia sebelum mengajukan
        $aset = Aset::find($request->id_aset);
        if ($aset->status_aset != 'tersedia') {
            return back()->with('error', 'Barang sedang tidak tersedia.');
        }

        // Simpan ke database dengan status 'pending'
        // Asumsi: Anda mendapatkan id_pegawai dari relasi User yang login
        $pegawai = Auth::user()->pegawai; // Pastikan relasi user->pegawai sudah ada

        Peminjaman::create([
            'id_pegawai' => $pegawai->id_pegawai,
            'id_aset' => $request->id_aset,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'alasan' => $request->alasan,
            'status' => 'pending',
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Pengajuan berhasil dikirim, menunggu persetujuan Admin.');
    }

    // --- FITUR UNTUK ADMIN ---

    // 2. Admin Menyetujui Pengajuan
    public function approve($id)
    {
        // 1. Cari data peminjaman
        $peminjaman = Peminjaman::findOrFail($id);
        
        // 2. Cari data aset terkait
        $aset = Aset::find($peminjaman->id_aset);

        // --- VALIDASI PENTING (Double Check) ---
        // Cek apakah detik ini status aset masih 'tersedia'?
        // Jika statusnya sudah 'digunakan' (karena baru saja di-approve admin untuk orang lain), maka BATALKAN.
        if ($aset->status_aset !== 'tersedia') {
            return back()->with('error', 'GAGAL! Aset ini sudah tidak tersedia (mungkin baru saja disetujui untuk peminjam lain).');
        }

        // 3. Jika lolos validasi, baru jalankan update data
        DB::transaction(function () use ($peminjaman, $aset) {
            // Update status peminjaman jadi disetujui
            $peminjaman->update(['status' => 'disetujui']);

            // Update status aset jadi digunakan agar tidak bisa dipinjam lagi
            $aset->update(['status_aset' => 'digunakan']);
        });

        return back()->with('success', 'Peminjaman disetujui. Stok aset telah dikunci.');
    }

    // 3. Admin Menolak Pengajuan
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'ditolak']);
        
        // Status aset tetap 'tersedia' karena ditolak
        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function indexAdmin()
{
    // 1. Data Permintaan Masuk (Pending)
    $pending = Peminjaman::with(['pegawai', 'aset'])
                ->where('status', 'pending')
                ->latest()
                ->get();

    // 2. Data Sedang Dipinjam (Disetujui/Active)
    // Diurutkan berdasarkan tanggal rencana kembali (yang paling dekat deadline di atas)
    $active = Peminjaman::with(['pegawai', 'aset'])
                ->where('status', 'disetujui')
                ->orderBy('tanggal_kembali', 'asc') 
                ->get();

    // 3. Data Riwayat (Selesai/Ditolak) - Ambil 50 terakhir saja agar ringan
    $history = Peminjaman::with(['pegawai', 'aset'])
                ->whereIn('status', ['kembali', 'ditolak'])
                ->latest()
                ->limit(50)
                ->get();
    $tahunList = Peminjaman::selectRaw('YEAR(updated_at) as tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    return view('admin.peminjaman.index', compact('pending', 'active', 'history', 'tahunList'));
}
    public function indexUser()
    {
        // 1. Ambil data pegawai dari user yang login
        $pegawai = Auth::user()->pegawai;

        // Cek jika data pegawai belum ada
        if (!$pegawai) {
            return redirect()->route('dashboard')->with('error', 'Silakan lengkapi data pegawai terlebih dahulu.');
        }

        // 2. Ambil data peminjaman milik pegawai tersebut
        $riwayat = Peminjaman::with('aset') // Load relasi aset biar nama aset muncul
                    ->where('id_pegawai', $pegawai->id_pegawai)
                    ->orderBy('created_at', 'desc') // Urutkan dari yang terbaru
                    ->paginate(10); // Gunakan pagination biar rapi

        // 3. Tampilkan ke view
        return view('admin.peminjaman.user_index', compact('riwayat'));
    }
    public function checkPending()
    {
        $count = \App\Models\Peminjaman::where('status', 'pending')->count();
        return response()->json(['count' => $count]);
    }
    public function returnAsset(Request $request, $id)
{
    // Validasi input kondisi
    $request->validate([
        'kondisi' => 'required|in:baik,rusak,hilang'
    ]);

    DB::transaction(function () use ($request, $id) {
        // 1. Ambil data peminjaman
        $peminjaman = Peminjaman::findOrFail($id);
        
        // 2. Ambil data aset terkait
        $aset = Aset::find($peminjaman->id_aset);

        // 3. Logika Update Status Aset berdasarkan Kondisi Fisik
        if ($request->kondisi == 'baik') {
            $aset->update([
                'status_aset' => 'tersedia',
                'kondisi_aset' => 'baik'
            ]);
        } elseif ($request->kondisi == 'rusak') {
            $aset->update([
                'status_aset' => 'rusak',
                'kondisi_aset' => 'rusak'
            ]);
        } else {
            // Jika Hilang, set status rusak (atau bisa tambah enum 'hilang' di tabel aset jika mau)
            $aset->update([
                'status_aset' => 'rusak', 
                'kondisi_aset' => 'rusak' 
            ]);
        }

        // 4. Update Data Peminjaman (Selesaikan Transaksi)
        $peminjaman->update([
            'status' => 'kembali',
            'tanggal_kembali_real' => Carbon::now(), // Catat tanggal hari ini
            'kondisi_pengembalian' => $request->kondisi
        ]);
    });

    return back()->with('success', 'Aset berhasil dikembalikan. Stok dan kondisi telah diperbarui.');
}
    // cetak PDF
    public function cetakPdf(Request $request)
{
    $bulan = $request->bulan;
    $tahun = $request->tahun;

    $namaBulan = Carbon::create()
        ->month((int) $bulan)
        ->translatedFormat('F');

    $data = Peminjaman::with(['pegawai', 'aset'])
        ->where('status', 'kembali')
        ->whereMonth('updated_at', $bulan)
        ->whereYear('updated_at', $tahun)
        ->orderBy('updated_at', 'asc')
        ->get();

    $pdf = Pdf::loadView('admin.peminjaman.pdf', [
        'data'  => $data,
        'bulan' => $namaBulan,
        'tahun' => $tahun,
    ])->setPaper('A4', 'portrait');

    return $pdf->stream(
        'Riwayat_Peminjaman_Aset_' . $bulan . '_' . $tahun . '.pdf'
    );
}

}
