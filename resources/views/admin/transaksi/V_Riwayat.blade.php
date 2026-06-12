@extends('layouts.V_Auth')

@section('title', 'Riwayat Transaksi - SIMBRO Admin')

@section('header_title', 'Riwayat Transaksi')
@section('header_desc', 'Transaksi yang telah selesai atau dibatalkan')
@section('header_back_url', route('admin.manajemen'))
@section('header_back_text', 'Kembali ke Manajemen')

@section('content')

<div class="flex-1 bg-white">

    <div class="max-w-5xl mx-auto py-8 px-4">
        {{-- Form Filter --}}
        <div class="card-form p-5 mb-8">
            <form method="GET" class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-44">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-44">
                </div>
                <button type="submit" class="btn-orange px-5 py-2 rounded-md text-sm font-bold transition shadow-sm">Filter</button>
                <a href="{{ route('admin.riwayat.transaksi') }}" class="bg-[#FF6B00] border-2 border-[#FF6B00] text-white hover:bg-[#e66000] hover:border-[#e66000] px-5 py-2 rounded-md text-sm font-bold transition">Reset</a>
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
                    <div class="px-5 py-3 border-b border-gray-100 flex justify-between items-start sm:items-center bg-gray-50/50 cursor-pointer gap-3" onclick="toggleDetail(this)">
                        <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                            <i class="fas {{ $icon }} text-xs text-[#FF6B00] mt-1 sm:mt-0"></i>
                            <span class="badge-status {{ $badgeClass }} border">{{ ucfirst($status) }}</span>
                            <span class="text-sm text-gray-500">#{{ $t->transaksi_id }}</span>
                            <span class="text-sm text-gray-500 w-full sm:w-auto mt-1 sm:mt-0">{{ \Carbon\Carbon::parse($t->tanggal_pemesanan)->format('d M Y H:i') }} WIB</span>
                        </div>
                        <i class="fas fa-chevron-down dropdown-icon text-gray-400 flex-shrink-0 mt-1 sm:mt-0"></i>
                    </div>

                    <div class="p-5">
                        <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg">{{ $t->details->first()->produk->nama_produk ?? '-' }}</h3>
                                <div class="mt-1 space-y-1">
                                    <p class="text-sm text-gray-600">Jumlah: <span class="font-semibold">{{ $t->details->sum('jumlah') }}</span></p>
                                    <p class="text-xl font-bold text-[#FF6B00]">Rp{{ number_format($t->details->sum('total_harga'), 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="text-left sm:text-right text-sm w-full sm:w-auto border-t border-gray-100 sm:border-0 pt-3 sm:pt-0 mt-2 sm:mt-0">
                                <div class="text-gray-600 flex items-center sm:justify-end gap-1">
                                    <i class="fas fa-user text-[#FF6B00] text-xs w-4 text-center"></i> {{ $t->user->nama_lengkap }}
                                </div>
                                <div class="text-gray-500 text-xs mt-1 flex items-center sm:justify-end gap-1">
                                    <i class="fas fa-credit-card w-4 text-center"></i> {{ $t->metode_pembayaran ?? 'Transfer' }}
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
                <div class="text-center text-gray-500 py-12 card-form">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                    <p>Belum ada transaksi final</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

