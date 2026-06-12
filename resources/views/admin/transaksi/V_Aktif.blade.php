@extends('layouts.V_Auth')

@section('title', 'Transaksi Aktif - SIMBRO Admin')

@section('header_title', 'Transaksi Aktif')
@section('header_desc', 'Kelola status pesanan yang belum selesai')
@section('header_back_url', route('admin.manajemen'))
@section('header_back_text', 'Kembali ke Manajemen')

@section('content')

<div class="flex-1 bg-white">

    <div class="max-w-6xl mx-auto py-8 px-4">

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
                <a href="{{ route('admin.transaksi.V_Aktif') }}" class="bg-[#FF6B00] border-2 border-[#FF6B00] text-white hover:bg-[#e66000] hover:border-[#e66000] px-5 py-2 rounded-md text-sm font-bold transition">Reset</a>
            </form>
        </div>


        {{-- Daftar Transaksi Aktif --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($transaksis as $t)
                @php
                    $status = $t->status->nama_status;
                    $badgeClass = match($status) {
                        'diproses' => 'bg-blue-100 text-blue-700 border-blue-200',
                        'dibayar' => 'bg-green-100 text-green-700 border-green-200',
                        'dikirim' => 'bg-purple-100 text-purple-700 border-purple-200',
                        default => 'btn-red border-gray-200',
                    };
                    $icon = match($status) {
                        'diproses' => 'fa-clock',
                        'dibayar' => 'fa-check-circle',
                        'dikirim' => 'fa-truck',
                        default => 'fa-info-circle',
                    };
                @endphp
                <div class="card-transaksi overflow-hidden shadow-sm">
                    <div class="px-5 py-3 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-gray-50/50 gap-2 sm:gap-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <i class="fas {{ $icon }} text-xs text-[#FF6B00]"></i>
                            <span class="badge-status {{ $badgeClass }} border">
                                {{ ucfirst($status) }}
                            </span>
                            <span class="text-xs text-gray-500">#{{ $t->transaksi_id }}</span>
                        </div>
                        <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($t->tanggal_pemesanan)->format('d M Y H:i') }} WIB</span>
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

                    <div class="px-5 py-3 border-t border-gray-100 bg-gray-50/30 flex justify-end">
                        <a href="{{ route('admin.transaksi.V_Detail', $t->transaksi_id) }}" class="btn-[#FF6B00] border-2 border-[#FF6B00] text-[#FF6B00] text-sm font-medium px-4 py-1.5 rounded-lg inline-flex items-center gap-1 transition">
                            Detail <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center text-gray-500 py-12 card-form">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                    <p>Tidak ada transaksi aktif</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
