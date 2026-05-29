@extends('layouts.auth')

@section('title', 'Manajemen - SIMBRO Admin')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Header mengikuti style V_DataCustomer -->
    <div class="bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] text-white px-6 py-6 md:px-10">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo-simbro-2.png') }}" alt="SIMBRO" class="h-12 w-auto">
                <div>
                    <h1 class="text-2xl font-bold">Manajemen</h1>
                    <p class="text-orange-100 text-sm">Kelola informasi pembayaran, transaksi, dan laporan</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <a href="{{ route('admin.home') }}" class="inline-flex items-center gap-2 text-white hover:underline transition text-sm font-bold"> Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-12 px-4">
        <div class="space-y-12">
            <!-- Card 1 - Informasi Pembayaran -->
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

            <!-- Card 2 - Transaksi Aktif -->
            <div class="flex flex-col md:flex-row gap-8 items-center">
                <div class="w-full md:w-1/2 order-2 md:order-1">
                    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition">
                        <p class="text-gray-600 leading-relaxed">Lihat semua transaksi aktif yang belum selesai. Ubah status pesanan, input nomor resi, dan pantau pembayaran.</p>
                    </div>
                </div>
                <div class="w-full md:w-1/2 order-1 md:order-2 transform transition duration-300 hover:-translate-y-1">
                    <a href="{{ route('admin.transaksi.aktif') }}" class="block bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] rounded-2xl shadow-xl p-6 text-white hover:shadow-2xl transition-all duration-300 group">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-exchange-alt text-4xl group-hover:scale-110 transition-transform"></i>
                            <h3 class="text-xl font-bold">Transaksi Aktif</h3>
                        </div>
                        <p class="mt-2 text-orange-100">Kelola status dan lihat detail transaksi</p>
                    </a>
                </div>
            </div>

            <!-- Card 3 - Riwayat Transaksi -->
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

            <!-- Card 4 - Laporan Penjualan -->
            <div class="flex flex-col md:flex-row gap-8 items-center">
                <div class="w-full md:w-1/2 order-2 md:order-1">
                    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition">
                        <p class="text-gray-600 leading-relaxed">Analisa penjualan dengan grafik pendapatan, total transaksi, dan transaksi dibatalkan. Filter berdasarkan rentang tanggal.</p>
                    </div>
                </div>
                <div class="w-full md:w-1/2 order-1 md:order-2 transform transition duration-300 hover:-translate-y-1">
                    <a href="{{ route('admin.laporan.penjualan') }}" class="block bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] rounded-2xl shadow-xl p-6 text-white hover:shadow-2xl transition-all duration-300 group">
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
