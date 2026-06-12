@extends('layouts.V_Auth')

@section('title', 'Riwayat Transaksi - SIMBRO')

@section('content')
<style>
    .card-riwayat-customer {
        transition: all 0.2s ease;
        background: white;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }
    .card-riwayat-customer:hover {
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
    }
    .badge-orange { background-color: #ffedd5; color: #9a3412; border: 1px solid #fdba74; }
    .badge-green { background-color: #dcfce7; color: #166534; border: 1px solid #86efac; }
    .badge-blue { background-color: #dbeafe; color: #1e40af; border: 1px solid #93c5fd; }
    .badge-teal { background-color: #ccfbf1; color: #115e59; border: 1px solid #5eead4; }
    .badge-red { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    .info-payment {
        border: 1px dashed #FF6B00;
        background-color: #fffaf5;
        border-radius: 0.75rem;
        padding: 1rem;
    }
    .dropdown-icon {
        transition: transform 0.2s;
    }
    .rotate-180 {
        transform: rotate(180deg);
    }
    /* ULASAN */
    .rating-star {
        font-size: 1.5rem;
        cursor: pointer;
        color: #d1d5db;
        transition: all 0.2s;
    }
    .rating-star:hover {
        transform: scale(1.1);
    }
    .rating-star.active {
        color: #fbbf24;
    }
    .review-card {
        background: linear-gradient(135deg, #fff9f5, #ffffff);
        border: 1px solid #ffe0c4;
        border-radius: 1rem;
        padding: 1rem;
        margin-top: 0.5rem;
        position: relative;
    }
    .review-form-card {
        background: #fefaf5;
        border-radius: 1rem;
        padding: 1rem;
        border: 1px solid #ffe0c4;
    }
    .review-disabled-card {
        background: #f9f9f9;
        border: 1px dashed #e5e7eb;
        border-radius: 1rem;
        padding: 1rem;
        opacity: 0.7;
    }
    .btn-submit-review {
        background: #FF6B00;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 600;
        font-size: 0.75rem;
        transition: 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-submit-review:hover {
        background: #e05a00;
        transform: scale(1.02);
    }
    .delete-review-btn {
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        padding: 0.25rem 0.75rem;
        font-size: 0.7rem;
        font-weight: 500;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        cursor: pointer;
        color: #6b7280;
    }
    .delete-review-btn:hover {
        background-color: #fef2f2;
        border-color: #fecaca;
        color: #ef4444;
    }
</style>
@section('header_title', 'Riwayat Transaksi')
@section('header_desc', 'Daftar semua pembelian yang telah Anda lakukan')
@section('header_back_url', route('customer.home'))
@section('header_back_text', 'Kembali ke Beranda')

@section('content')

<div class="flex-1 bg-white">

    <div class="max-w-5xl mx-auto py-8 px-4">
        <div class="card-form p-5 mb-8">
            <form method="GET" class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-44">
                </div>
                <button type="submit" class="btn-orange px-5 py-2 rounded-md text-sm font-bold transition shadow-sm">Filter</button>
                <a href="{{ route('customer.riwayat.transaksi') }}" class="bg-[#FF6B00] hover:bg-[#e05a00] text-white px-5 py-2 rounded-md text-sm font-bold transition shadow-sm">Reset</a>
            </form>
        </div>

        <div class="space-y-6">
            @forelse($transaksis as $t)
                @php
                    $status = $t->status->nama_status;
                    $steps = ['diproses', 'dibayar', 'dikirim', 'diterima'];
                    $currentStep = array_search($status, $steps);
                    $isCancelled = ($status == 'dibatalkan');
                    $statusWarna = $t->status->warna ?? 'gray';
                    $badgeColorClass = match($statusWarna) {
                        'orange' => 'badge-orange', 'green' => 'badge-green', 'blue' => 'badge-blue',
                        'teal' => 'badge-teal', 'red' => 'badge-red', default => 'btn-red',
                    };
                    $icon = $isCancelled ? 'fa-times-circle' : 'fa-check-double';
                    $ulasan = $t->ulasan;
                @endphp
                <div class="card-riwayat-customer" data-transaksi-id="{{ $t->transaksi_id }}">
                    <div class="px-5 py-3 border-b border-gray-100 flex justify-between items-start sm:items-center bg-gray-50/50 cursor-pointer gap-3" onclick="toggleDetail(this)">
                        <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                            <i class="fas {{ $icon }} text-xs text-[#FF6B00] mt-1 sm:mt-0"></i>
                            <span class="badge-status {{ $badgeColorClass }}">{{ ucfirst($status) }}</span>
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
                                    <i class="fas fa-user text-[#FF6B00] text-xs w-4 text-center"></i> {{ $t->user->nama_lengkap ?? 'Customer' }}
                                </div>
                                <div class="text-gray-500 text-xs mt-1 flex items-center sm:justify-end gap-1">
                                    <i class="fas fa-credit-card w-4 text-center"></i> {{ $t->metode_pembayaran ?? 'Transfer' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!$isCancelled)
                    <div class="px-5 pb-3">
                        <div class="relative p-4 border-y border-gray-100 bg-gray-50/30 rounded-lg">
                            <div class="flex justify-between items-center">
                                @foreach($steps as $index => $step)
                                    <div class="flex flex-col items-center flex-1">
                                        <div class="w-8 h-8 rounded-full {{ $index <= $currentStep ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center text-white">
                                            @if($step == 'diproses') <i class="fas fa-hourglass-half"></i>
                                            @elseif($step == 'dibayar') <i class="fas fa-check"></i>
                                            @elseif($step == 'dikirim') <i class="fas fa-truck"></i>
                                            @else <i class="fas fa-check-double"></i> @endif
                                        </div>
                                        <span class="text-xs mt-1 capitalize">{{ $step }}</span>
                                    </div>
                                    @if($index < count($steps)-1)
                                        <div class="flex-1 h-0.5 {{ $index < $currentStep ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
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
                                    <div class="flex items-center justify-between">
                                        <span>{{ $t->no_resi ?? '-' }}</span>
                                        @if($t->no_resi)
                                            <a href="{{ route('customer.resi.cetak', $t->transaksi_id) }}" target="_blank" class="text-[#FF6B00] font-semibold text-xs hover:underline flex items-center gap-1">
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
                                        <i class="fas fa-external-link-alt text-[#FF6B00] text-xs"></i>
                                        <a class="text-[#FF6B00] font-semibold text-sm ml-1" href="{{ \App\Helpers\ImageHelper::getUrl($t->bukti_pembayaran) }}" target="_blank"> Lihat bukti</a>
                                    @else -
                                    @endif
                                </div>
                            </div>
                            @if($status == 'diproses')
                                <div class="mt-2 flex justify-end">
                                    <form action="{{ route('customer.transaksi.batalkan', $t->transaksi_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-red px-4 py-1.5 rounded-md text-sm font-bold transition flex items-center gap-2">
                                            <i class="fas fa-times-circle"></i> Batalkan Pesanan
                                        </button>
                                    </form>
                                </div>
                            @elseif(in_array($status, ['dibayar', 'dikirim', 'diterima']))
                                <div class="mt-2 flex justify-end">
                                    <button disabled class="bg-gray-400 text-white px-4 py-1.5 rounded-md text-sm font-bold cursor-not-allowed flex items-center gap-2"
                                            title="Transaksi sudah {{ $status }}, tidak dapat dibatalkan">
                                        <i class="fas fa-times-circle"></i> Batalkan Pesanan
                                    </button>
                                </div>
                            @endif
                            @if($status != 'dibatalkan')
                            <div class="border-t border-gray-100 pt-4">
                                @if($status == 'diterima')
                                    @if($ulasan)
                                        <div class="review-card">
                                            <div class="flex justify-between items-start gap-4">
                                                <div class="flex-1 min-w-0 max-w-full overflow-hidden">
                                                    <div class="flex items-center gap-1 mb-2">
                                                        @for($i=1; $i<=5; $i++)
                                                            <i class="fas fa-star {{ $i <= $ulasan->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                                        @endfor
                                                    </div>
                                                    <p class="text-gray-700 text-sm italic break-words whitespace-pre-wrap max-w-full overflow-hidden">"{{ $ulasan->ulasan }}"</p>
                                                    <p class="text-xs text-gray-400 mt-2">{{ \Carbon\Carbon::parse($ulasan->created_at)->format('d M Y H:i') }}</p>
                                                </div>
                                                <button type="button" class="delete-review-btn flex-shrink-0" data-ulasan-id="{{ $ulasan->ulasan_id }}" title="Hapus ulasan">
                                                    <i class="fas fa-trash-alt text-xs"></i> Hapus
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="review-form-card">
                                            <textarea rows="3" class="review-text w-full border border-orange-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#FF6B00]" placeholder="Bagaimana pengalaman Anda dengan produk ini?"></textarea>
                                            <div class="flex flex-wrap items-center justify-between mt-3 gap-3">
                                                <div class="flex items-center gap-1 rating-stars">
                                                    @for($i=1; $i<=5; $i++)
                                                        <i class="fas fa-star rating-star" data-rating="{{ $i }}"></i>
                                                    @endfor
                                                </div>
                                                <button type="button" class="submit-review-btn btn-submit-review">
                                                    <i class="fas fa-paper-plane"></i> Kirim Ulasan
                                                </button>
                                            </div>
                                            <input type="hidden" class="selected-rating" value="0">
                                        </div>
                                    @endif
                                @else
                                    <div class="review-disabled-card">
                                        <div class="flex items-center gap-2 text-gray-400">
                                            <i class="fas fa-lock text-xs"></i>
                                            <p class="text-sm italic">Buat ulasan setelah produk yang dipesan telah diterima</p>
                                        </div>
                                        <div class="flex items-center gap-1 mt-2">
                                            @for($i=1; $i<=5; $i++)
                                                <i class="fas fa-star text-gray-300 text-sm"></i>
                                            @endfor
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 card-form">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                    <p class="text-gray-500">Belum ada transaksi</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.rating-star').forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            const starsContainer = this.closest('.rating-stars');
            const hiddenInput = this.closest('.review-form-card').querySelector('.selected-rating');
            if (hiddenInput) hiddenInput.value = rating;
            starsContainer.querySelectorAll('.rating-star').forEach((s, idx) => {
                if (idx < rating) s.classList.add('active');
                else s.classList.remove('active');
            });
        });
    });

    function reloadAfterModalClosed() {
        const checkInterval = setInterval(() => {
            const modal = document.getElementById('lightboxModal');
            if (modal && modal.classList.contains('invisible')) {
                clearInterval(checkInterval);
                location.reload();
            }
        }, 200);
    }

    document.querySelectorAll('.submit-review-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const card = this.closest('.card-riwayat-customer');
            const transaksiId = card.getAttribute('data-transaksi-id');
            const textarea = card.querySelector('.review-text');
            const ratingInput = card.querySelector('.selected-rating');
            const rating = ratingInput ? parseInt(ratingInput.value) : 0;
            const ulasan = textarea ? textarea.value.trim() : '';

            if (rating === 0 && ulasan === '') {
                if (typeof showLightbox === 'function') showLightbox('Harap isi data ulasan dengan lengkap', 'error');
                else alert('Harap isi data ulasan dengan lengkap');
                return;
            }
            if (rating === 0) {
                if (typeof showLightbox === 'function') showLightbox('Harap pilih rating bintang terlebih dahulu', 'error');
                else alert('Harap pilih rating bintang terlebih dahulu');
                return;
            }
            if (ulasan === '') {
                if (typeof showLightbox === 'function') showLightbox('Harap isi deskripsi ulasan terlebih dahulu', 'error');
                else alert('Harap isi deskripsi ulasan terlebih dahulu');
                return;
            }

            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
            btn.disabled = true;

            try {
                const response = await fetch('{{ route("customer.ulasan.store") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ transaksi_id: transaksiId, rating: rating, ulasan: ulasan })
                });
                const data = await response.json();
                if (data.success) {
                    if (typeof showLightbox === 'function') {
                        showLightbox(data.message, 'success');
                        reloadAfterModalClosed();
                    } else {
                        alert(data.message);
                        location.reload();
                    }
                } else {
                    if (typeof showLightbox === 'function') showLightbox(data.message, 'error');
                    else alert(data.message);
                }
            } catch (err) {
                console.error(err);
                if (typeof showLightbox === 'function') showLightbox('Terjadi kesalahan, silakan coba lagi', 'error');
                else alert('Terjadi kesalahan');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    });

    document.querySelectorAll('.delete-review-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const ulasanId = this.getAttribute('data-ulasan-id');
            if (typeof showConfirm === 'function') {
                showConfirm('Apakah anda yakin ingin menghapus ulasan?', async () => {
                    try {
                        const response = await fetch(`{{ url('customer/ulasan') }}/${ulasanId}`, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
                        });
                        const data = await response.json();
                        if (data.success) {
                            if (typeof showLightbox === 'function') {
                                showLightbox(data.message, 'success');
                                reloadAfterModalClosed();
                            } else {
                                alert(data.message);
                                location.reload();
                            }
                        } else {
                            if (typeof showLightbox === 'function') showLightbox(data.message, 'error');
                            else alert(data.message);
                        }
                    } catch (err) {
                        console.error(err);
                        if (typeof showLightbox === 'function') showLightbox('Terjadi kesalahan', 'error');
                        else alert('Terjadi kesalahan');
                    }
                });
            } else if (confirm('Apakah anda yakin ingin menghapus ulasan?')) { }
        });
    });
</script>
@endsection
