<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil semua pengaduan yang statusnya 'pending' atau 'processing'
        // 2. 'with('user')' untuk mengambil data pelapor (relasi)
        // 3. 'latest()' untuk mengurutkan dari yang terbaru
        $pengaduanAktif = Pengaduan::with('user')
                            ->whereIn('status', ['pending', 'processing'])
                            ->latest()
                            ->paginate(15, ['*'], 'aktif_page');

    // 2. Ambil pengaduan yang SELESAI ('done')
    $pengaduanSelesai = Pengaduan::with('user')
                            ->where('status', 'done')
                            ->latest()
                            ->paginate(15, ['*'], 'selesai_page');

    // 3. Kirim KEDUA set data ke view
    return view('admin.dashboard', [
        'pengaduanAktif' => $pengaduanAktif,
        'pengaduanSelesai' => $pengaduanSelesai
    ]);
    }

    public function update(Request $request, Pengaduan $pengaduan)
{
    // 1. Validasi input dari form admin
    $validated = $request->validate([
        'status' => 'required|in:pending,processing,done',
        'balasan_admin' => 'nullable|string',
    ]);

    // 2. Simpan perubahan ke database
    $pengaduan->update($validated);

    // 3. LOGIKA NOTIFIKASI WHATSAPP
    if ($pengaduan->wasChanged('status')) {
        try {
            $pelapor = $pengaduan->user;
            $nomorTujuan = $pelapor->no_wa; // Mengambil dari kolom no_wa
            
            $nomorTujuan = preg_replace('/[^0-9]/', '', $nomorTujuan);

            // 2. Cek apakah nomor diawali '08'
            if (substr($nomorTujuan, 0, 2) == '08') {
                // Ganti '08' dengan '628'
                $nomorTujuan = '62' . substr($nomorTujuan, 1);
            }

            if ($nomorTujuan) {
                // Siapkan pesan notifikasi
                $statusText = strtoupper($validated['status']);
                $pesan = "Halo, *{$pelapor->name}*!\n\n";
                $pesan .= "Status laporan Anda \"{$pengaduan->judul}\" telah diperbarui menjadi *{$statusText}*.\n\n";

                if ($validated['balasan_admin']) {
                    $pesan .= "Catatan dari Admin:\n";
                    $pesan .= "_{$validated['balasan_admin']}_\n\n";
                }
                $pesan .= "Terima kasih.";
              $response = Http::withHeaders([
                  'Authorization' => env('WHATSAPP_TOKEN') // <-- Kirim sebagai Header
              ])->withOptions([
                  'verify' => false // Disable SSL verification to fix certificate error
              ])->post('https://api.fonnte.com/send', [
                  'target' => $nomorTujuan,
                  'message' => $pesan
                  // <-- Kita hapus 'token' dari body
              ]);

                Log::info('Respon API WA:', $response->json());
            }

        } catch (\Exception $e) {
            Log::error('Gagal kirim WA: ' . $e->getMessage());
        }
    }

    // 4. Kembalikan ke dashboard admin dengan pesan sukses
    return redirect()->route('admin.dashboard')->with('success', 'Laporan berhasil diperbarui!');
    }

    public function statistik()
{
    // 1. Ambil SEMUA pengaduan dari database
    $allPengaduan = Pengaduan::all();

    // 2. Hitung Kartu Statistik
    $stats = [
        'total' => $allPengaduan->count(),
        'pending' => $allPengaduan->whereIn('status', ['pending', 'processing'])->count(),
        'done' => $allPengaduan->where('status', 'done')->count(),
    ];

    // 3. Siapkan Data untuk Grafik Kategori (Chart.js)
    $kategoriLabels = ['Fasilitas', 'Keamanan', 'Kebersihan', 'IT']; // Sesuaikan jika perlu
    $kategoriData = [];
    foreach ($kategoriLabels as $kategori) {
        $kategoriData[] = $allPengaduan->where('kategori', $kategori)->count();
    }

    // 4. Siapkan Data untuk Grafik Status (Chart.js)
    $statusLabels = ['Pending', 'Processing', 'Selesai', 'Ditolak'];
    $statusData = [
        $allPengaduan->where('status', 'pending')->count(),
        $allPengaduan->where('status', 'processing')->count(),
        $allPengaduan->where('status', 'done')->count(),
        $allPengaduan->where('status', 'rejected')->count(), // (Jika Anda pakai 'rejected')
    ];

    // 5. Kirim semua data ke view
    return view('admin.statistik', [
        'stats' => $stats,
        'kategoriLabels' => json_encode($kategoriLabels), // Kirim sebagai JSON
        'kategoriData' => json_encode($kategoriData),   // Kirim sebagai JSON
        'statusLabels' => json_encode($statusLabels),   // Kirim sebagai JSON
        'statusData' => json_encode($statusData),     // Kirim sebagai JSON
    ]);
    }
}