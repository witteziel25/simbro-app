@extends('layouts.auth')

@section('title', 'Informasi Pembayaran - SIMBRO Admin')

@section('content')
<style>
    .card-info {
        transition: all 0.2s ease;
        border-left: 4px solid #FF6B00 !important;
        background: white;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        border-left-width: 4px !important;
        overflow: hidden;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }
    .card-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .rekening-card {
        transition: all 0.2s ease;
        border-left: 4px solid #FF6B00 !important;
        background: white;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        border-left-width: 4px !important;
        overflow: hidden;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }
    .rekening-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    /* Style untuk konten CKEditor (supaya tampil rapi) */
    .ck-content {
        line-height: 1.6;
    }
    .ck-content ul, .ck-content ol {
        list-style: revert !important;
        padding-left: 1.5rem !important;
        margin: 0.5rem 0 !important;
    }
    .ck-content li {
        margin: 0.25rem 0;
    }
    .ck-content h1, .ck-content h2, .ck-content h3 {
        font-size: revert;
        font-weight: revert;
        margin: 0.5rem 0;
    }
    .ck-content p {
        margin: 0 0 0.5rem 0;
    }
    .badge-bank {
        background: #FF6B00;
        color: white;
        font-weight: 600;
        font-size: 0.7rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        display: inline-block;
    }
    .info-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: #334155;
        margin-top: 0.5rem;
    }
    .info-row i {
        width: 1.25rem;
        color: #FF6B00;
    }
    .btn-outline-orange {
        border: 1px solid #FF6B00;
        color: #FF6B00;
        transition: all 0.2s;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: transparent;
        cursor: pointer;
    }
    .btn-outline-orange:hover {
        background-color: #FF6B00;
        color: white;
    }
    .btn-outline-red {
        border: 1px solid #ef4444;
        color: #ef4444;
        transition: all 0.2s;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: transparent;
        cursor: pointer;
    }
    .btn-outline-red:hover {
        background-color: #ef4444;
        color: white;
    }
    .rekening-item-editing {
        opacity: 0.5;
        transition: opacity 0.2s;
        pointer-events: none;
    }
</style>

<div class="min-h-screen bg-gray-50">
    <!-- Header (tidak berubah) -->
    <div class="bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] text-white px-6 py-6 md:px-10">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo-simbro-2.png') }}" class="h-12 w-auto">
                <div>
                    <h1 class="text-2xl font-bold">Informasi Pembayaran</h1>
                    <p class="text-orange-100 text-sm">Kelola card informasi dan rekening bank</p>
                </div>
            </div>
            <div>
                <i class="fas fa-arrow-left"></i>
                <a href="{{ route('admin.manajemen') }}" class="inline-flex items-center gap-2 text-white hover:underline text-sm font-bold">Kembali ke Manajemen</a>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto py-8 px-4">
        <!-- Tombol tambah card -->
        <div class="flex justify-end mb-6">
            <a href="{{ route('admin.informasi-pembayaran.create') }}" class="bg-[#FF6B00] hover:bg-orange-700 font-semibold text-white px-4 py-2 rounded-lg shadow flex items-center gap-2 transition">
                <i class="fas fa-plus"></i> Tambah Informasi
            </a>
        </div>

        <!-- Daftar card informasi -->
        <div class="space-y-8">
            @foreach($informasis as $info)
                @php
                    $icon = 'fa-info-circle';
                    if (str_contains($info->judul, 'Syarat') || str_contains($info->judul, 'Ketentuan')) {
                        $icon = 'fa-file-alt';
                    } elseif (!str_contains($info->judul, 'Informasi Pembayaran') && !str_contains($info->judul, 'Syarat')) {
                        $icon = 'fa-bullhorn';
                    }
                    $isDefault = (str_contains($info->judul, 'Informasi Pembayaran') || str_contains($info->judul, 'Syarat'));
                @endphp
                <div class="card-info">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center flex-wrap gap-3">
                        <div class="flex items-center gap-2">
                            <i class="fas {{ $icon }} text-[#FF6B00]"></i>
                            <h2 class="font-semibold text-gray-800">{{ $info->judul }}</h2>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.informasi-pembayaran.edit', $info->informasi_id) }}" class="btn-outline-orange">
                                <i class="fas fa-edit text-xs"></i> Edit
                            </a>
                            @if(!$isDefault && $info->transaksis->count() == 0)
                            <button type="button" class="btn-outline-red" onclick="confirmDeleteCard({{ $info->informasi_id }})">
                                <i class="fas fa-trash-alt text-xs"></i> Hapus
                            </button>
                            @endif
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="ck-content">
                            {!! $info->deskripsi !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Daftar Rekening Bank -->
        <div class="rekening-card mt-8">
            <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-2">
                    <i class="fas fa-university text-[#FF6B00]"></i>
                    <h2 class="font-semibold text-gray-800">Daftar Rekening Bank</h2>
                </div>
            </div>
            <div class="p-5">
                <!-- Form tambah / edit rekening -->
                <div id="rekeningFormContainer" class="mb-8 p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <form id="rekeningForm" method="POST" action="{{ route('admin.rekening.store') }}">
                        @csrf
                        <input type="hidden" name="informasi_id" id="informasi_id" value="{{ $informasis->first()->informasi_id ?? '' }}">
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        <input type="hidden" name="rekening_id" id="editRekeningId" value="">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <input type="text" name="nama_bank" id="nama_bank" placeholder="Nama Bank" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#FF6B00] focus:border-[#FF6B00]" required>
                            <input type="text" name="nomor_rekening" id="nomor_rekening" placeholder="No. Rekening" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#FF6B00] focus:border-[#FF6B00]" required>
                            <input type="text" name="pemilik_rekening" id="pemilik_rekening" placeholder="Pemilik Rekening" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#FF6B00] focus:border-[#FF6B00]">
                        </div>
                        <div class="mt-3 flex gap-3">
                            <button type="submit" id="submitRekeningBtn" class="bg-[#FF6B00] hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow flex items-center gap-2">
                                <i class="fas fa-plus"></i> Tambah Rekening
                            </button>
                            <button type="button" id="cancelEditBtn" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hidden items-center gap-2">
                                <i class="fas fa-times"></i> Batal
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Daftar rekening -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5" id="rekeningList">
                    @php $rekeningAll = \App\Models\M_RekeningPembayaran::all(); @endphp
                    @forelse($rekeningAll as $rek)
                    <div class="border border-gray-200 rounded-xl p-4 hover:shadow-sm transition rekening-item" data-id="{{ $rek->rekening_id }}">
                        <div class="flex justify-between items-start pb-2">
                            <div class="badge-bank">{{ $rek->nama_bank }}</div>
                            <div class="flex gap-2">
                                <button type="button" class="btn-outline-orange edit-rekening-btn" data-id="{{ $rek->rekening_id }}" data-nama="{{ $rek->nama_bank }}" data-nomor="{{ $rek->nomor_rekening }}" data-pemilik="{{ $rek->pemilik_rekening }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="{{ route('admin.rekening.destroy', $rek->rekening_id) }}" method="POST" class="inline delete-rekening-form" data-id="{{ $rek->rekening_id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn-outline-red delete-rekening-btn">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="info-row font-bold"><i class="fas fa-credit-card"></i> {{ $rek->nomor_rekening }}</div>
                        <div class="info-row font-regular"><i class="fas fa-user"></i> {{ $rek->pemilik_rekening ?? '-' }}</div>
                    </div>
                    @empty
                    <div class="col-span-2 text-center text-gray-500 py-6">Belum ada rekening</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi konfirmasi hapus card informasi
    function confirmDeleteCard(id) {
        if (typeof showConfirm === 'function') {
            showConfirm('Yakin ingin menghapus card informasi ini?', function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ url("admin/informasi-pembayaran") }}/' + id;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            });
        } else {
            if (confirm('Yakin ingin menghapus card informasi ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ url("admin/informasi-pembayaran") }}/' + id;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        }
    }

    // Konfirmasi hapus rekening
    document.querySelectorAll('.delete-rekening-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-rekening-form');
            if (typeof showConfirm === 'function') {
                showConfirm('Yakin ingin menghapus rekening ini?', () => form.submit());
            } else {
                if (confirm('Yakin ingin menghapus rekening ini?')) form.submit();
            }
        });
    });

    // ... kode edit rekening (sama seperti sebelumnya) ...
    const rekeningForm = document.getElementById('rekeningForm');
    const formMethod = document.getElementById('formMethod');
    const editRekeningId = document.getElementById('editRekeningId');
    const namaBankInput = document.getElementById('nama_bank');
    const nomorRekeningInput = document.getElementById('nomor_rekening');
    const pemilikRekeningInput = document.getElementById('pemilik_rekening');
    const submitBtn = document.getElementById('submitRekeningBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn');

    let editingItemDiv = null;

    function resetToAddMode() {
        formMethod.value = 'POST';
        editRekeningId.value = '';
        namaBankInput.value = '';
        nomorRekeningInput.value = '';
        pemilikRekeningInput.value = '';
        rekeningForm.action = '{{ route("admin.rekening.store") }}';
        submitBtn.innerHTML = '<i class="fas fa-plus"></i> Tambah Rekening';
        cancelEditBtn.classList.add('hidden');
        if (editingItemDiv) {
            editingItemDiv.classList.remove('rekening-item-editing');
            editingItemDiv = null;
        }
    }

    function editRekening(id, nama, nomor, pemilik, element) {
        resetToAddMode();
        formMethod.value = 'PUT';
        editRekeningId.value = id;
        namaBankInput.value = nama;
        nomorRekeningInput.value = nomor;
        pemilikRekeningInput.value = pemilik || '';
        rekeningForm.action = `{{ url("admin/rekening") }}/${id}`;
        submitBtn.innerHTML = '<i class="fas fa-save"></i> Simpan';
        cancelEditBtn.classList.remove('hidden');
        if (element) {
            editingItemDiv = element.closest('.rekening-item');
            if (editingItemDiv) {
                editingItemDiv.classList.add('rekening-item-editing');
            }
        }
    }

    document.querySelectorAll('.edit-rekening-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            const nomor = this.getAttribute('data-nomor');
            const pemilik = this.getAttribute('data-pemilik');
            const cardItem = this.closest('.rekening-item');
            editRekening(id, nama, nomor, pemilik, cardItem);
        });
    });

    cancelEditBtn.addEventListener('click', function() {
        resetToAddMode();
    });

    rekeningForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(rekeningForm);
        const method = formMethod.value;
        let url = rekeningForm.action;
        let fetchOptions = {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        };
        if (method === 'PUT') {
            formData.append('_method', 'PUT');
        }

        fetch(url, fetchOptions)
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; }).catch(() => { throw new Error('Server error'); });
                }
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    return { success: true, message: 'Rekening berhasil disimpan' };
                }
            })
            .then(data => {
                if (data.success) {
                    if (typeof showLightbox === 'function') {
                        showLightbox(data.message, 'success');
                    } else {
                        alert(data.message);
                    }
                    setTimeout(() => location.reload(), 1500);
                } else {
                    let errorMsg = data.message || 'Harap isi data dengan benar';
                    if (typeof showLightbox === 'function') {
                        showLightbox(errorMsg, 'error');
                    } else {
                        alert(errorMsg);
                    }
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                let errorMsg = error.message || 'Terjadi kesalahan. Silakan coba lagi.';
                if (typeof showLightbox === 'function') {
                    showLightbox(errorMsg, 'error');
                } else {
                    alert(errorMsg);
                }
            });
    });
</script>
@endsection
