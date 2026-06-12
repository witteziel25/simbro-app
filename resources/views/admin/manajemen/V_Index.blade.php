@extends('layouts.V_Auth')

@section('title', 'Manajemen - SIMBRO Admin')

@section('header_title', 'Manajemen')
@section('header_desc', 'Kelola informasi pembayaran, transaksi, dan laporan')
@section('header_back_url', route('admin.home'))
@section('header_back_text', 'Kembali ke Beranda Admin')

@section('content')
<div class="flex-1 bg-white">
    <div class="max-w-7xl mx-auto py-12 px-4">
        <div class="space-y-12">
            {{-- Card Informasi Pembayaran --}}
            <div class="flex flex-col md:flex-row gap-8 items-center">
                <div class="w-full md:w-1/2 transform transition duration-300 hover:-translate-y-1">
                    <a href="{{ route('admin.informasi-pembayaran') }}" class="block bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] rounded-2xl shadow-xl p-6 text-white hover:shadow-2xl transition-all duration-300 group">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-credit-card text-4xl group-hover:scale-110 transition-transform"></i>
                            <h3 class="text-xl font-bold">Informasi Pembayaran</h3>
                        </div>
                        <p class="mt-2 text-orange-100">Kelola deskripsi pembayaran dan daftar rekening bank</p>
                    </a>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition">
                        <p class="text-gray-600 leading-relaxed">Atur informasi pembayaran yang akan ditampilkan ke customer saat melakukan pembelian. Tambah, edit, atau hapus rekening bank.</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-8 items-center">
                <div class="w-full md:w-1/2 order-2 md:order-1">
                    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition">
                        <p class="text-gray-600 leading-relaxed">Lihat semua transaksi aktif yang belum selesai. Ubah status pesanan, input nomor resi, dan pantau pembayaran.</p>
                    </div>
                </div>
                <div class="w-full md:w-1/2 order-1 md:order-2 transform transition duration-300 hover:-translate-y-1">
                    <a href="{{ route('admin.transaksi.V_Aktif') }}" class="block bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] rounded-2xl shadow-xl p-6 text-white hover:shadow-2xl transition-all duration-300 group">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-exchange-alt text-4xl group-hover:scale-110 transition-transform"></i>
                            <h3 class="text-xl font-bold">Transaksi Aktif</h3>
                        </div>
                        <p class="mt-2 text-orange-100">Kelola status dan lihat detail transaksi</p>
                    </a>
                </div>
            </div>
            {{-- Card Riwayat Transaksi --}}
            <div class="flex flex-col md:flex-row gap-8 items-center">
                <div class="w-full md:w-1/2 transform transition duration-300 hover:-translate-y-1">
                    <a href="{{ route('admin.riwayat.transaksi') }}" class="block bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] rounded-2xl shadow-xl p-6 text-white hover:shadow-2xl transition-all duration-300 group">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-history text-4xl group-hover:scale-110 transition-transform"></i>
                            <h3 class="text-xl font-bold">Riwayat Transaksi</h3>
                        </div>
                        <p class="mt-2 text-orange-100">Lihat histori pesanan customer</p>
                    </a>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition">
                        <p class="text-gray-600 leading-relaxed">Pantau riwayat lengkap transaksi pelanggan, filter berdasarkan tanggal, dan lihat detail.</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-8 items-center">
                <div class="w-full md:w-1/2 order-2 md:order-1">
                    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition">
                        <p class="text-gray-600 leading-relaxed">Analisa penjualan dengan grafik pendapatan, total transaksi, dan transaksi dibatalkan. Filter berdasarkan rentang tanggal.</p>
                    </div>
                </div>
                <div class="w-full md:w-1/2 order-1 md:order-2 transform transition duration-300 hover:-translate-y-1">
                    <a href="{{ route('admin.laporan.V_Penjualan') }}" class="block bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] rounded-2xl shadow-xl p-6 text-white hover:shadow-2xl transition-all duration-300 group">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-chart-line text-4xl group-hover:scale-110 transition-transform"></i>
                            <h3 class="text-xl font-bold">Laporan Penjualan</h3>
                        </div>
                        <p class="mt-2 text-orange-100">Lihat grafik dan statistik penjualan</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
