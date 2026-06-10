@extends('layouts.V_Auth')

@section('title', 'Detail Transaksi - SIMBRO Admin')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row">
    <div class="w-full md:w-80 bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] flex flex-col justify-center px-10 py-10 text-white">
        <img src="{{ asset('images/logo-simbro-2.png') }}" alt="SIMBRO" class="h-28 w-28 mb-4">
        <h1 class="text-3xl font-bold mb-3">Detail Transaksi</h1>
        <p class="text-orange-100 text-sm mb-4">Informasi lengkap pesanan customer dan kelola status transaksi.</p>
        <div class="mt-3">
            <i class="fas fa-arrow-left"></i>
            <a href="{{ route('admin.transaksi.V_Aktif') }}" class="inline-flex items-center gap-2 text-white hover:underline transition text-sm font-bold"> Kembali ke Transaksi Aktif</a>
        </div>
    </div>
    <div class="flex-1 bg-white p-6 md:p-10 flex items-center">
        <div class="max-w-4xl w-full mx-auto">
            <div class="flex flex-wrap justify-between items-center mb-6 pb-4 border-b border-gray-100">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide">ID Transaksi</p>
                    <p class="text-2xl font-mono font-bold text-gray-800">#{{ $transaksi->transaksi_id }}</p>
                </div>
                @php
                    $status = $transaksi->status->nama_status ?? 'diproses';
                    $statusColor = match($status) {
                        'diproses' => 'bg-blue-100 text-blue-700',
                        'dibayar' => 'bg-green-100 text-green-700',
                        'dikirim' => 'bg-purple-100 text-purple-700',
                        'diterima' => 'bg-teal-100 text-teal-700',
                        'dibatalkan' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }} flex items-center gap-1">
                    <i class="fas fa-{{ $status == 'diproses' ? 'clock' : ($status == 'dibayar' ? 'check-circle' : ($status == 'dikirim' ? 'truck' : ($status == 'diterima' ? 'check-double' : 'times-circle'))) }}"></i>
                    {{ ucfirst($status) }}
                </span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="space-y-1">
                    <p class="text-xs font-semibold text-gray-400 uppercase">Customer</p>
                    <p class="text-gray-800">{{ $transaksi->user->nama_lengkap }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs font-semibold text-gray-400 uppercase">Tanggal Pemesanan</p>
                    <p class="text-gray-800">{{ \Carbon\Carbon::parse($transaksi->tanggal_pemesanan)->format('d M Y H:i') }} WIB</p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs font-semibold text-gray-400 uppercase">Metode Pembayaran</p>
                    <p class="text-gray-800">{{ $transaksi->metode_pembayaran ?? 'Transfer Bank' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs font-semibold text-gray-400 uppercase">Nomor Resi</p>
                    @if($transaksi->no_resi)
                        <p class="font-mono text-sm bg-gray-100 px-2 py-0.5 rounded inline-block">{{ $transaksi->no_resi }}</p>
                    @else
                        <p class="text-gray-400 italic">Belum digenerate</p>
                    @endif
                </div>
            </div>
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-3">
                    <i class="fas fa-box-open text-[#FF6B00]"></i>
                    <h3 class="font-semibold text-gray-800">Detail Produk</h3>
                </div>
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase border-b">
                            <tr>
                                <th class="px-4 py-3 text-left">Produk</th>
                                <th class="px-4 py-3 text-center w-24">Jumlah</th>
                                <th class="px-4 py-3 text-right w-36">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($transaksi->details as $detail)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $detail->produk->nama_produk }}</td>
                                <td class="px-4 py-3 text-center text-gray-600">{{ $detail->jumlah }}</td>
                                <td class="px-4 py-3 text-right font-mono text-gray-700">Rp{{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 border-t border-gray-200">
                            <tr>
                                <td colspan="2" class="px-4 py-3 text-right font-semibold text-gray-700">TOTAL</td>
                                <td class="px-4 py-3 text-right font-bold text-[#FF6B00]">Rp{{ number_format($transaksi->details->sum('total_harga'), 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-receipt text-[#FF6B00]"></i>
                    <h3 class="font-semibold text-gray-800">Bukti Pembayaran</h3>
                </div>
                @if($transaksi->bukti_pembayaran)
                    <a href="{{ Storage::url($transaksi->bukti_pembayaran) }}" target="_blank" class="inline-flex items-center gap-2 text-sm text-[#FF6B00] border border-orange-200 bg-orange-50 px-3 py-1.5 rounded-lg hover:bg-orange-100 transition">
                        <i class="fas fa-eye"></i> Lihat Berkas
                    </a>
                @else
                    <p class="text-gray-400 text-sm italic">Belum ada bukti pembayaran</p>
                @endif
            </div>
            <div class="pt-4 border-t border-gray-100">
                <div class="flex items-center gap-2 mb-3">
                    <i class="fas fa-sync-alt text-[#FF6B00]"></i>
                    <h3 class="font-semibold text-gray-800">Ubah Status Transaksi</h3>
                </div>
                <form id="formUpdateStatus" method="POST" action="{{ route('admin.transaksi.update.status', $transaksi->transaksi_id) }}" class="flex flex-col sm:flex-row gap-3 items-start sm:items-end">
                    @csrf
                    @method('PUT')
                    <div class="relative w-full sm:w-72">
                        <select name="status_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white text-sm text-gray-700 appearance-none cursor-pointer focus:ring-1 focus:ring-[#FF6B00] focus:border-[#FF6B00]">
                            @foreach($statuses as $status)
                                <option value="{{ $status->status_id }}" {{ $transaksi->status_id == $status->status_id ? 'selected' : '' }}>
                                    {{ ucfirst($status->nama_status) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>
                    <button type="submit" class="bg-[#FF6B00] hover:bg-orange-700 text-white font-bold text-sm px-5 py-2 rounded-lg shadow-sm flex items-center gap-2 transition">
                        <i class="fas fa-save text-md"></i> Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function() {
        const form = document.getElementById('formUpdateStatus');
        if (!form) return;

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            formData.append('_method', 'PUT');

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Ambil teks status yang dipilih
                    const selectedOption = form.querySelector('select[name="status_id"] option:checked');
                    const selectedStatusText = selectedOption ? selectedOption.innerText.trim().toLowerCase() : '';

                    // Tentukan redirect berdasarkan status
                    let redirectUrl = '';
                    if (selectedStatusText === 'dibatalkan' || selectedStatusText === 'diterima') {
                        redirectUrl = '{{ route("admin.riwayat.transaksi") }}';
                    } else {
                        redirectUrl = '{{ route("admin.transaksi.V_Aktif") }}';
                    }

                    if (typeof showLightbox === 'function') {
                        showLightbox(data.message, 'success');
                        setTimeout(() => {
                            window.location.href = redirectUrl;
                        }, 1500);
                    } else {
                        alert(data.message);
                        window.location.href = redirectUrl;
                    }
                } else {
                    if (typeof showLightbox === 'function') {
                        showLightbox(data.message, 'error');
                    } else {
                        alert(data.message);
                    }
                }
            })
            .catch(() => {
                if (typeof showLightbox === 'function') {
                    showLightbox('Terjadi kesalahan. Silakan coba lagi.', 'error');
                } else {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });
    })();
</script>
@endpush
@endsection
