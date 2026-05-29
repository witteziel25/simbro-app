@extends('layouts.auth')

@section('title', 'Transaksi Aktif - SIMBRO Admin')

@section('content')
<style>
    .card-transaksi {
        transition: all 0.2s ease;
        border-left: 4px solid #FF6B00;
    }
    .card-transaksi:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.02em;
    }
    .btn-outline-orange {
        border: 1px solid #FF6B00;
        color: #FF6B00;
        transition: all 0.2s;
    }
    .btn-outline-orange:hover {
        background-color: #FF6B00;
        color: white;
    }
</style>

<div class="min-h-screen bg-gray-50">
    <!-- Header Oranye (sama seperti data customer) -->
    <div class="bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] text-white px-6 py-6 md:px-10">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo-simbro-2.png') }}" alt="SIMBRO" class="h-12 w-auto">
                <div>
                    <h1 class="text-2xl font-bold">Transaksi Aktif</h1>
                    <p class="text-orange-100 text-sm">Kelola status pesanan yang belum selesai</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <a href="{{ route('admin.manajemen') }}" class="inline-flex items-center gap-2 text-white hover:underline transition text-sm font-bold"> Kembali ke Manajemen</a>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto py-8 px-4">
        <!-- Filter -->
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
                <a href="{{ route('admin.transaksi.aktif') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-bold transition">Reset</a>
            </form>
        </div>

        <!-- Daftar transaksi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($transaksis as $t)
                @php
                    $status = $t->status->nama_status;
                    $badgeClass = match($status) {
                        'diproses' => 'bg-blue-100 text-blue-700 border-blue-200',
                        'dibayar' => 'bg-green-100 text-green-700 border-green-200',
                        'dikirim' => 'bg-purple-100 text-purple-700 border-purple-200',
                        default => 'bg-gray-100 text-gray-700 border-gray-200',
                    };
                    $icon = match($status) {
                        'diproses' => 'fa-clock',
                        'dibayar' => 'fa-check-circle',
                        'dikirim' => 'fa-truck',
                        default => 'fa-info-circle',
                    };
                @endphp
                <div class="card-transaksi bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                    <!-- Header card -->
                    <div class="px-5 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <div class="flex items-center gap-2">
                            <i class="fas {{ $icon }} text-xs text-[#FF6B00]"></i>
                            <span class="badge-status {{ $badgeClass }} border">
                                {{ ucfirst($status) }}
                            </span>
                            <span class="text-xs text-gray-500">#{{ $t->transaksi_id }}</span>
                        </div>
                        <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($t->tanggal_pemesanan)->format('d M Y H:i') }} WIB</span>
                    </div>

                    <!-- Body card -->
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

                    <!-- Footer card (tombol detail) -->
                    <div class="px-5 py-3 border-t border-gray-100 bg-gray-50/30 flex justify-end">
                        <a href="{{ route('admin.transaksi.detail', $t->transaksi_id) }}" class="btn-outline-orange text-sm font-medium px-4 py-1.5 rounded-lg inline-flex items-center gap-1 transition">
                            Detail <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center text-gray-500 py-12 bg-white rounded-xl border border-gray-200">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                    <p>Tidak ada transaksi aktif</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
