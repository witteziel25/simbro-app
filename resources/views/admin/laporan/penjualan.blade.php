@extends('layouts.auth')

@section('title', 'Laporan Penjualan - SIMBRO Admin')

@section('content')
<style>
    .stats-card {
        transition: all 0.2s ease;
        border-left: 4px solid #FF6B00;
    }
    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }
    /* Pembungkus wajib Chart.js agar tinggi terkontrol secara absolut dan tidak melar */
    .chart-container {
        position: relative;
        height: 280px;
        width: 100%;
    }
</style>

<div class="min-h-screen bg-gray-50">
    <div class="bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] text-white px-6 py-6 md:px-10">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo-simbro-2.png') }}" alt="SIMBRO" class="h-12 w-auto">
                <div>
                    <h1 class="text-2xl font-bold">Laporan Penjualan</h1>
                    <p class="text-orange-100 text-sm">Statistik pendapatan dan transaksi</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <a href="{{ route('admin.manajemen') }}" class="inline-flex items-center gap-2 text-white hover:underline transition text-sm font-bold"> Kembali ke Manajemen</a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-8 px-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-8">
            <form method="GET" class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai', \Carbon\Carbon::yesterday()->toDateString()) }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-44">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai', \Carbon\Carbon::today()->toDateString()) }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-44">
                </div>
                <button type="submit" class="bg-[#FF6B00] hover:bg-orange-700 text-white px-5 py-2 rounded-lg text-sm font-bold transition shadow-sm">Filter</button>
                <a href="{{ route('admin.laporan.penjualan') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-bold transition">Reset</a>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stats-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">TOTAL PENDAPATAN</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">Rp{{ number_format($total_pendapatan, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center"><i class="fas fa-chart-line text-green-600"></i></div>
                </div>
            </div>
            <div class="stats-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">TOTAL TRANSAKSI SUKSES</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $total_transaksi }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center"><i class="fas fa-shopping-cart text-blue-600"></i></div>
                </div>
            </div>
            <div class="stats-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">DIBATALKAN</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $total_dibatalkan }}</p>
                    </div>
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center"><i class="fas fa-times-circle text-red-600"></i></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-100">
                    <i class="fas fa-chart-line text-[#FF6B00]"></i>
                    <h3 class="font-semibold text-gray-800">Grafik Pendapatan (Juta Rupiah)</h3>
                </div>
                <div class="chart-container">
                    <canvas id="chartPendapatan"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-100">
                    <i class="fas fa-chart-bar text-[#FF6B00]"></i>
                    <h3 class="font-semibold text-gray-800">Grafik Status Transaksi</h3>
                </div>
                <div class="chart-container">
                    <canvas id="chartStatus"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartData = @json($chartData);
        const statusData = @json($statusData);
        const labels = chartData.labels;

        if (!labels || labels.length === 0) {
            console.warn('Tidak ada data untuk grafik');
            return;
        }

        // 1. Grafik Pendapatan
        const ctxPendapatan = document.getElementById('chartPendapatan').getContext('2d');
        new Chart(ctxPendapatan, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan (Juta Rp)',
                    data: chartData.pendapatanJuta,
                    borderColor: '#FF6B00',
                    backgroundColor: 'rgba(255, 107, 0, 0.05)',
                    borderWidth: 2,
                    pointBackgroundColor: '#FF6B00',
                    pointBorderColor: '#fff',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Menyesuaikan tinggi dengan .chart-container CSS
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                // Format tooltip menggunakan koma desimal Indonesia
                                const nominal = ctx.raw.toFixed(2).replace('.', ',');
                                return `${nominal} Juta Rp`;
                            }
                        }
                    },
                    legend: { position: 'top' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0,
                        max: 5, // Nilai puncak sumbu Y dikunci di angka 5 Juta
                        title: { display: true, text: 'Juta Rupiah' },
                        ticks: {
                            stepSize: 0.5, // Detail skala per 0,5 Juta (Rp 500.000) untuk mencegah duplikasi teks pembulatan
                            callback: function(val) {
                                // Mengubah titik menjadi koma untuk format akademis/formal Indonesia (misal: 1,5 Jt)
                                return val.toString().replace('.', ',') + ' Jt';
                            }
                        }
                    }
                }
            }
        });

        // 2. Grafik Status Transaksi
        const ctxStatus = document.getElementById('chartStatus').getContext('2d');
        new Chart(ctxStatus, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Dibayar', data: statusData.dibayar, backgroundColor: 'rgba(34, 197, 94, 0.7)', borderRadius: 6, barPercentage: 0.65 },
                    { label: 'Dikirim', data: statusData.dikirim, backgroundColor: 'rgba(59, 130, 246, 0.7)', borderRadius: 6, barPercentage: 0.65 },
                    { label: 'Diterima', data: statusData.diterima, backgroundColor: 'rgba(20, 184, 166, 0.7)', borderRadius: 6, barPercentage: 0.65 },
                    { label: 'Dibatalkan', data: statusData.dibatalkan, backgroundColor: 'rgba(239, 68, 68, 0.7)', borderRadius: 6, barPercentage: 0.65 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Menyesuaikan tinggi dengan .chart-container CSS
                plugins: {
                    tooltip: { callbacks: { label: (ctx) => `${ctx.dataset.label}: ${ctx.raw}` } },
                    legend: { position: 'top' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 }
                    }
                }
            }
        });
    });
</script>
@endsection
