@extends('layouts.V_Auth')

@section('title', 'Riwayat Transaksi - SIMBRO Admin')

@section('content')

<div class="min-h-screen bg-gray-50">
    <div class="bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] text-white px-6 py-6 md:px-10">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo-simbro-2.png') }}" alt="SIMBRO" class="h-12 w-auto">
                <div>
                    <h1 class="text-2xl font-bold">Riwayat Transaksi</h1>
                    <p class="text-orange-100 text-sm">Transaksi yang telah selesai atau dibatalkan</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <a href="{{ route('admin.manajemen') }}" class="inline-flex items-center gap-2 text-white hover:underline transition text-sm font-bold"> Kembali ke Manajemen</a>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto py-8 px-4">
        {{-- Form Filter --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-8">
            <form method="GET" class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-44">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-44">
                </div>
                <button type="submit" class="bg-[#FF6B00] hover:bg-orange-700 text-white px-5 py-2 rounded-lg text-sm font-bold transition shadow-sm">Filter</button>
                <a href="{{ route('admin.riwayat.transaksi') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-bold transition">Reset</a>
            </form>
        </div>

        {{-- Daftar Riwayat Transaksi --}}
        <div class="space-y-6">
            @forelse($transaksis as $t)
                @php
                    $status = $t->status->nama_status ?? 'dibatalkan';
                    $badgeClass = $status == 'dibatalkan' ? 'bg-red-100 text-red-700 border-red-200' : 'bg-teal-100 text-teal-700 border-teal-200';
                    $icon = $status == 'dibatalkan' ? 'fa-times-circle' : 'fa-check-double';
                @endphp
                <div class="card-riwayat">
                    <div class="px-5 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 cursor-pointer" onclick="toggleDetail(this)">
                        <div class="flex items-center gap-3">
                            <i class="fas {{ $icon }} text-xs text-[#FF6B00]"></i>
                            <span class="badge-status {{ $badgeClass }} border">{{ ucfirst($status) }}</span>
                            <span class="text-sm text-gray-500">#{{ $t->transaksi_id }}</span>
                            <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($t->tanggal_pemesanan)->format('d M Y H:i') }} WIB</span>
                        </div>
                        <i class="fas fa-chevron-down dropdown-icon text-gray-400"></i>
                    </div>

                    <div class="p-5">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg">{{ $t->details->first()->produk->nama_produk ?? '-' }}</h3>
                                <div class="mt-1 space-y-1">
                                    <p class="text-sm text-gray-600">Jumlah: <span class="font-semibold">{{ $t->details->sum('jumlah') }}</span></p>
                                    <p class="text-xl font-bold text-[#FF6B00]">Rp{{ number_format($t->details->sum('total_harga'), 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="text-right text-sm">
                                <div class="text-gray-600 flex items-center gap-1">
                                    <i class="fas fa-user text-[#FF6B00] text-xs"></i> {{ $t->user->nama_lengkap }}
                                </div>
                                <div class="text-gray-500 text-xs mt-1">
                                    <i class="fas fa-credit-card"></i> {{ $t->metode_pembayaran ?? 'Transfer' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Panel Detail Transaksi --}}
                    <div class="detail-panel hidden border-t border-gray-100">
                        <div class="p-5 space-y-5">
                            <div class="info-payment">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-credit-card text-[#FF6B00] text-sm"></i>
                                    <span class="font-semibold text-gray-700 text-sm">{{ $t->informasiPembayaran->judul ?? 'Informasi Pembayaran & Pengiriman' }}</span>
                                </div>
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    {{ strip_tags($t->informasiPembayaran->deskripsi ?? 'Belum ada informasi') }}
                                </p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <span class="font-semibold text-gray-600 block mb-1">ID Transaksi</span>
                                    <span class="text-gray-800 font-mono">{{ $t->transaksi_id }}</span>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <span class="font-semibold text-gray-600 block mb-1">No. Resi</span>
                                    <div class="flex items-center justify-between gap-2">
                                        <span>{{ $t->no_resi ?? '-' }}</span>
                                        @if($t->no_resi)
                                            <a href="{{ route('admin.resi.cetak', $t->transaksi_id) }}" target="_blank" class="text-[#FF6B00] font-semibold text-xs hover:underline flex items-center gap-1">
                                                <i class="fas fa-print"></i> Cetak
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <span class="font-semibold text-gray-600 block mb-1">Rekening Tujuan</span>
                                    @if($t->rekening)
                                        <span class="font-semibold">{{ $t->rekening->nama_bank }}</span> - {{ $t->rekening->nomor_rekening }}<br>
                                        <span class="text-xs text-gray-500">a.n. {{ $t->rekening->pemilik_rekening }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <span class="font-semibold text-gray-600 block mb-1">Bukti Pembayaran</span>
                                    @if($t->bukti_pembayaran)
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[#FF6B00]"></i><a class="text-[#FF6B00] font-semibold text-sm" href="{{ Storage::url($t->bukti_pembayaran) }}" target="_blank"> Lihat bukti pembayaran</a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-12 bg-white rounded-xl border border-gray-200">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                    <p>Belum ada transaksi final</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

