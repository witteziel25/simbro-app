<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\M_Transaksi;
use App\Models\M_DetailTransaksi;
use App\Models\M_Produk;
use App\Models\M_InformasiPembayaran;
use App\Models\M_RekeningPembayaran;
use App\Models\M_StatusTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class C_Transaksi extends Controller
{
    // --- Manajemen Admin ---
    public function manajemen()
    {
        return view('admin.manajemen.V_Index');
    }
    // --- Informasi Pembayaran (Admin) ---
    public function showHallInformasiPembayaran()
    {
        $informasis = M_InformasiPembayaran::with('rekening')->orderBy('informasi_id')->get();
        return view('admin.informasi_pembayaran.V_Index', compact('informasis'));
    }

    public function showFormTambah()
    {
        return view('admin.informasi_pembayaran.V_Create');
    }

    public function simpanInformasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ], [
            'judul.required' => 'Judul informasi harus diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('lightbox_message', 'Harap isi data dengan lengkap')
                ->with('lightbox_type', 'error');
        }

        M_InformasiPembayaran::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.informasi-pembayaran')
            ->with('lightbox_message', 'Informasi baru berhasil ditambahkan')
            ->with('lightbox_type', 'success');
    }


    public function showFormUbah($id)
    {
        $informasi = M_InformasiPembayaran::findOrFail($id);
        return view('admin.informasi_pembayaran.V_Edit', compact('informasi'));
    }

    public function updateInformasi(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ], [
            'judul.required' => 'Judul informasi harus diisi',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Judul harus diisi', 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('lightbox_message', 'Harap isi data dengan lengkap')
                ->with('lightbox_type', 'error');
        }

        $informasi = M_InformasiPembayaran::findOrFail($id);
        $informasi->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Informasi berhasil diubah']);
        }

        return redirect()->route('admin.informasi-pembayaran')
            ->with('lightbox_message', 'Informasi berhasil diubah')
            ->with('lightbox_type', 'success');
    }

    public function hapusInformasi($id)
    {
        $informasi = M_InformasiPembayaran::findOrFail($id);
        if ($informasi->transaksis()->count() > 0) {
            return redirect()->route('admin.informasi-pembayaran')
                ->with('lightbox_message', 'Card tidak dapat dihapus karena sudah digunakan di transaksi.', 'error');
        }
        $informasi->delete();
        return redirect()->route('admin.informasi-pembayaran')
            ->with('lightbox_message', 'Card informasi berhasil dihapus.', 'success');
    }
    // --- Rekening Bank ---
    public function simpanRekening(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'informasi_id' => 'required|exists:informasi_pembayaran,informasi_id',
            'nama_bank' => 'required|string',
            'nomor_rekening' => 'required|string',
            'pemilik_rekening' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()
                ->with('lightbox_message', 'Harap isi data rekening dengan lengkap')->with('lightbox_type', 'error');
        }

        M_RekeningPembayaran::create($request->only(['informasi_id', 'nama_bank', 'nomor_rekening', 'pemilik_rekening']));
        return redirect()->route('admin.informasi-pembayaran')
            ->with('lightbox_message', 'Rekening berhasil ditambahkan')->with('lightbox_type', 'success');
    }

    public function showFormUbahRekening($id)
    {
        $rekening = M_RekeningPembayaran::findOrFail($id);
        return view('admin.informasi_pembayaran.edit_rekening', compact('rekening'));
    }

    public function updateRekening(Request $request, $id)
    {
        $rekening = M_RekeningPembayaran::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nama_bank' => 'required|string',
            'nomor_rekening' => 'required|string',
            'pemilik_rekening' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()
                ->with('lightbox_message', 'Harap isi data rekening dengan lengkap')->with('lightbox_type', 'error');
        }

        $rekening->update($request->only(['nama_bank', 'nomor_rekening', 'pemilik_rekening']));
        return redirect()->route('admin.informasi-pembayaran')
            ->with('lightbox_message', 'Rekening berhasil diubah')->with('lightbox_type', 'success');
    }

    public function hapusRekening($id)
    {
        $rekening = M_RekeningPembayaran::findOrFail($id);
        $rekening->delete();
        return redirect()->route('admin.informasi-pembayaran')
            ->with('lightbox_message', 'Rekening berhasil dihapus', 'success');
    }
    // --- Transaksi Customer ---
    /**
     * Helper: cek ketersediaan produk (tidak dihapus & stok cukup)
     */
    private function checkProductAvailability($produk_id, $jumlah)
    {
        $produk = M_Produk::withoutTrashed()->find($produk_id);
        if (!$produk) {
            return ['available' => false, 'message' => 'Produk saat ini sudah tidak tersedia'];
        }
        if ($jumlah > $produk->stok) {
            return ['available' => false, 'message' => 'Stok tidak mencukupi'];
        }
        if ($produk->kategori == 'Bibit Ayam Broiler' && $jumlah < 60) {
            return ['available' => false, 'message' => 'Minimal pembelian bibit ayam broiler adalah 60 ekor'];
        }
        if ($produk->kategori == 'Ayam Broiler Dewasa' && $jumlah < 2) {
            return ['available' => false, 'message' => 'Minimal pembelian ayam broiler dewasa adalah 2 kg'];
        }
        return ['available' => true, 'produk' => $produk];
    }

    public function beli($produk_id)
    {
        $produk = M_Produk::findOrFail($produk_id);
        $informasis = M_InformasiPembayaran::with('rekening')->get();
        return view('customer.transaksi.V_Pembelian', compact('produk', 'informasis'));
    }

    public function prepareCheckout(Request $request, $produk_id)
    {
        $validator = Validator::make($request->all(), [
            'jumlah' => 'required|integer|min:1',
            'metode_pembayaran' => 'required|string',
            'rekening_id' => 'required|exists:rekening_pembayaran,rekening_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $jumlah = $request->jumlah;
        $check = $this->checkProductAvailability($produk_id, $jumlah);
        if (!$check['available']) {
            return response()->json(['success' => false, 'message' => $check['message']], 422);
        }
        $produk = $check['produk'];

        $rekening = M_RekeningPembayaran::find($request->rekening_id);
        $totalHarga = $produk->harga * $jumlah;

        session([
            'temp_transaksi' => [
                'produk_id' => $produk_id,
                'jumlah' => $jumlah,
                'total_harga' => $totalHarga,
                'metode_pembayaran' => $request->metode_pembayaran,
                'rekening_id' => $request->rekening_id,
                'rekening_nama' => $rekening->nama_bank,
                'rekening_nomor' => $rekening->nomor_rekening,
                'nama_produk' => $produk->nama_produk,
            ]
        ]);

        return response()->json(['success' => true, 'message' => 'Silakan upload bukti pembayaran']);
    }

    public function clearCheckoutSession()
    {
        session()->forget('temp_transaksi');
        return response()->json(['success' => true]);
    }

    public function storeTransaksiWithBukti(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'bukti_pembayaran.required' => 'Harap upload bukti pembayaran',
            'bukti_pembayaran.image' => 'File harus berupa gambar',
            'bukti_pembayaran.max' => 'Ukuran maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $temp = session('temp_transaksi');
        if (!$temp) {
            return response()->json(['success' => false, 'message' => 'Sesi transaksi habis. Silakan pesan ulang.'], 422);
        }

        // Cek ulang ketersediaan produk
        $check = $this->checkProductAvailability($temp['produk_id'], $temp['jumlah']);
        if (!$check['available']) {
            session()->forget('temp_transaksi');
            return response()->json(['success' => false, 'message' => 'Produk saat ini sudah tidak tersedia. Hubungi contact person admin untuk refund'], 422);
        }

        $statusDiproses = M_StatusTransaksi::where('nama_status', 'diproses')->first();
        $informasiPembayaran = M_InformasiPembayaran::first();

        $transaksi = M_Transaksi::create([
            'user_id' => session('user_id'),
            'informasi_id' => $informasiPembayaran ? $informasiPembayaran->informasi_id : null,
            'rekening_id' => $temp['rekening_id'],
            'status_id' => $statusDiproses->status_id,
            'tanggal_pemesanan' => now(),
            'metode_pembayaran' => $temp['metode_pembayaran'],
        ]);

        M_DetailTransaksi::create([
            'transaksi_id' => $transaksi->transaksi_id,
            'produk_id' => $temp['produk_id'],
            'jumlah' => $temp['jumlah'],
            'total_harga' => $temp['total_harga'],
        ]);

        // Kurangi stok produk
        $produk = M_Produk::find($temp['produk_id']);
        if ($produk) {
            $produk->decrement('stok', $temp['jumlah']);
        }

        if ($request->hasFile('bukti_pembayaran')) {
            $path = \App\Helpers\ImageHelper::convertAndStoreAsWebp($request->file('bukti_pembayaran'), 'bukti_pembayaran');
            $transaksi->bukti_pembayaran = $path;
            $transaksi->save();
        }

        session()->forget('temp_transaksi');

        return response()->json(['success' => true, 'message' => 'Bukti pembayaran berhasil ditambahkan']);
    }

    public function showRiwayatTransaksi(Request $request)
    {
        $query = M_Transaksi::with(['status', 'details.produk', 'informasiPembayaran', 'rekening'])
            ->where('user_id', session('user_id'))
            ->orderBy('created_at', 'desc');

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_pemesanan', $request->tanggal);
        }

        $transaksis = $query->get();
        return view('customer.transaksi.V_Riwayat', compact('transaksis'));
    }

    public function batalkanPesanan($transaksi_id)
    {
        $transaksi = M_Transaksi::where('user_id', session('user_id'))->findOrFail($transaksi_id);
        if ($transaksi->status->nama_status == 'diproses') {
            // Kembalikan stok karena transaksi dibatalkan
            foreach ($transaksi->details as $detail) {
                $produk = $detail->produk;
                if ($produk) {
                    $produk->increment('stok', $detail->jumlah);
                }
            }
            $statusDibatalkan = M_StatusTransaksi::where('nama_status', 'dibatalkan')->first();
            $transaksi->status_id = $statusDibatalkan->status_id;
            $transaksi->save();
            return redirect()->route('customer.riwayat.transaksi')->with('lightbox_message', 'Pembatalan berhasil')->with('lightbox_type', 'success');
        } else {
            return redirect()->route('customer.riwayat.transaksi')->with('lightbox_message', 'Pembatalan tidak berhasil')->with('lightbox_type', 'error');
        }
    }
    // --- Transaksi Admin ---
    public function adminTransaksiAktif(Request $request)
    {
        $query = M_Transaksi::with(['user', 'status', 'details.produk', 'informasiPembayaran'])
            ->whereHas('status', function($q) {
                $q->whereNotIn('nama_status', ['dibatalkan', 'diterima']);
            })
            ->orderBy('created_at', 'desc');

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_pemesanan', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_pemesanan', '<=', $request->tanggal_selesai);
        }

        $transaksis = $query->get();
        return view('admin.transaksi.V_Aktif', compact('transaksis'));
    }

    public function adminRiwayatTransaksi(Request $request)
    {
        $query = M_Transaksi::with(['user', 'status', 'details.produk', 'informasiPembayaran', 'rekening'])
            ->whereHas('status', function($q) {
                $q->whereIn('nama_status', ['dibatalkan', 'diterima']);
            })
            ->orderBy('created_at', 'desc');

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_pemesanan', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_pemesanan', '<=', $request->tanggal_selesai);
        }

        $transaksis = $query->get();
        return view('admin.transaksi.V_Riwayat', compact('transaksis'));
    }

    public function showDetailTransaksiAdmin($id)
    {
        $transaksi = M_Transaksi::with(['user', 'status', 'details.produk' => function($q) {
            $q->withTrashed();
        }, 'informasiPembayaran.rekening', 'rekening'])->findOrFail($id);
        $statuses = M_StatusTransaksi::all();
        return view('admin.transaksi.V_Detail', compact('transaksi', 'statuses'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status_id' => 'required|exists:status_transaksi,status_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Data tidak valid'], 422);
        }

        $transaksi = M_Transaksi::with('details.produk')->findOrFail($id);
        $oldStatusId = $transaksi->status_id;
        $newStatusId = $request->status_id;

        $statusDiproses = M_StatusTransaksi::where('nama_status', 'diproses')->first();
        $statusDibayar = M_StatusTransaksi::where('nama_status', 'dibayar')->first();
        $statusDibatalkan = M_StatusTransaksi::where('nama_status', 'dibatalkan')->first();

        // Kembalikan stok jika dibatalkan dari status 'diproses'
        if ($statusDibatalkan && $newStatusId == $statusDibatalkan->status_id && $oldStatusId == $statusDiproses->status_id) {
            foreach ($transaksi->details as $detail) {
                $produk = $detail->produk;
                if ($produk) {
                    $produk->increment('stok', $detail->jumlah);
                }
            }
        }

        // Kembalikan stok jika dibatalkan dari status 'dibayar'
        if ($statusDibatalkan && $newStatusId == $statusDibatalkan->status_id && $oldStatusId == $statusDibayar->status_id) {
            foreach ($transaksi->details as $detail) {
                $produk = $detail->produk;
                if ($produk) {
                    $produk->increment('stok', $detail->jumlah);
                }
            }
        }

        $transaksi->status_id = $newStatusId;

        // Generate no resi jika status menjadi 'dibayar' dan no_resi kosong
        if ($statusDibayar && $newStatusId == $statusDibayar->status_id && empty($transaksi->no_resi)) {
            $tanggal = $transaksi->tanggal_pemesanan;
            $count = M_Transaksi::whereDate('tanggal_pemesanan', $tanggal)->count() + 1;
            $transaksi->no_resi = 'BROUM' . $count . date('Ymd', strtotime($tanggal));
        }

        $transaksi->save();

        return response()->json(['success' => true, 'message' => 'Informasi berhasil diubah']);
    }
    // --- Laporan Penjualan ---
    public function laporanPenjualan(Request $request)
    {
        $tanggalMulai = $request->filled('tanggal_mulai') ? $request->tanggal_mulai : \Carbon\Carbon::yesterday()->toDateString();
        $tanggalSelesai = $request->filled('tanggal_selesai') ? $request->tanggal_selesai : \Carbon\Carbon::today()->toDateString();

        $allTransaksi = M_Transaksi::with('status')
            ->whereDate('tanggal_pemesanan', '>=', $tanggalMulai)
            ->whereDate('tanggal_pemesanan', '<=', $tanggalSelesai)
            ->get();

        $successTransaksi = $allTransaksi->filter(fn($t) => in_array($t->status->nama_status, ['dibayar', 'dikirim', 'diterima']));

        $groupPendapatan = [];
        foreach ($successTransaksi as $t) {
            $date = \Carbon\Carbon::parse($t->tanggal_pemesanan)->toDateString();
            $groupPendapatan[$date] = ($groupPendapatan[$date] ?? 0) + $t->details->sum('total_harga');
        }

        $allDates = $allTransaksi->map(fn($t) => \Carbon\Carbon::parse($t->tanggal_pemesanan)->toDateString())
            ->unique()
            ->sort()
            ->values();

        $labels = $allDates->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M Y'))->values();
        $pendapatanJuta = $allDates->map(fn($date) => ($groupPendapatan[$date] ?? 0) / 1000000)->values();

        $statusMapping = ['dibayar' => [], 'dikirim' => [], 'diterima' => [], 'dibatalkan' => []];
        foreach ($allTransaksi as $t) {
            $status = $t->status->nama_status;
            $date = \Carbon\Carbon::parse($t->tanggal_pemesanan)->toDateString();
            if (isset($statusMapping[$status])) {
                $statusMapping[$status][$date] = ($statusMapping[$status][$date] ?? 0) + 1;
            }
        }

        $statusData = [
            'dibayar' => $allDates->map(fn($date) => $statusMapping['dibayar'][$date] ?? 0)->values(),
            'dikirim' => $allDates->map(fn($date) => $statusMapping['dikirim'][$date] ?? 0)->values(),
            'diterima' => $allDates->map(fn($date) => $statusMapping['diterima'][$date] ?? 0)->values(),
            'dibatalkan' => $allDates->map(fn($date) => $statusMapping['dibatalkan'][$date] ?? 0)->values(),
        ];

        $total_pendapatan = $successTransaksi->sum(fn($t) => $t->details->sum('total_harga'));
        $total_transaksi = $successTransaksi->count();
        $total_dibatalkan = $allTransaksi->filter(fn($t) => $t->status->nama_status == 'dibatalkan')->count();

        $chartData = [
            'labels' => $labels,
            'pendapatanJuta' => $pendapatanJuta,
        ];

        return view('admin.laporan.V_Penjualan', compact('total_pendapatan', 'total_transaksi', 'total_dibatalkan', 'chartData', 'statusData'));
    }

    public function cetakResi($transaksi_id)
    {
        $transaksi = M_Transaksi::with(['user', 'details.produk', 'informasiPembayaran'])->findOrFail($transaksi_id);

        if (session('role') == 0 && $transaksi->user_id != session('user_id')) {
            abort(403, 'Anda tidak memiliki akses ke resi ini.');
        }

        $logoPath = public_path('images/logo-simbro-1.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        $data = [
            'transaksi' => $transaksi,
            'logo' => $logoBase64,
            'alamat' => 'Jl. Gajah Mada Gg. 18 No. 14 Jember Jawa Timur',
            'telepon' => '+62 812 3456 7890',
            'nama_cv' => 'CV. Mitra Gemuk Bersama',
        ];

        $pdf = Pdf::loadView('pdf.V_Resi', $data);
        $pdf->setPaper([0, 0, 235, 550], 'portrait');
        return $pdf->download('resi_' . $transaksi->transaksi_id . '.pdf');
    }
}
