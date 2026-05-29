<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\M_InformasiPembayaran;

class InformasiPembayaranSeeder extends Seeder
{
    public function run()
    {
        // Card 1: Informasi Pembayaran & Pengiriman
        M_InformasiPembayaran::create([
            'judul' => 'Informasi Pembayaran & Pengiriman',
            'deskripsi' => '<p>Pembelian akan dikonfirmasi oleh admin jika customer selesai melakukan pembayaran dan memberikan bukti pembayaran yang sesuai. Informasi lebih lanjut terkait pengiriman produk akan diberitahukan oleh admin melalui nomor WhatsApp resmi SIMBRO.</p>',
        ]);

        // Card 2: Syarat & Ketentuan Pembelian
        M_InformasiPembayaran::create([
            'judul' => 'Syarat & Ketentuan Pembelian SIMBRO',
            'deskripsi' => '<p>Mohon perhatikan Syarat & Ketentuan di bawah ini sebelum Anda menyelesaikan transaksi...</p>',
        ]);
    }
}
