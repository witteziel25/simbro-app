@extends('layouts.V_Auth')

@section('title', 'Informasi Pembayaran - SIMBRO Admin')

@section('header_title', 'Informasi Pembayaran')
@section('header_desc', 'Kelola card informasi dan rekening bank')
@section('header_back_url', route('admin.manajemen'))
@section('header_back_text', 'Kembali ke Manajemen')

@section('content')

<div class="flex-1 bg-white">
    <div class="max-w-5xl mx-auto py-8 px-4">
        <div class="flex justify-end mb-6">
            <a href="{{ route('admin.informasi-pembayaran.create') }}" class="bg-[#FF6B00] hover:bg-orange-700 font-semibold text-white px-4 py-2 rounded-md shadow flex items-center gap-2 transition">
                <i class="fas fa-plus"></i> Tambah Informasi
            </a>
        </div>

        {{-- Daftar Card Informasi Pembayaran --}}
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

        {{-- Daftar Rekening Bank --}}
        <div class="rekening-card mt-8">
            <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-2">
                    <i class="fas fa-university text-[#FF6B00]"></i>
                    <h2 class="font-semibold text-gray-800">Daftar Rekening Bank</h2>
                </div>
            </div>
            <div class="p-5">
                {{-- Form Tambah/Edit Rekening Bank --}}
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
                            <button type="submit" id="submitRekeningBtn" class="btn-orange px-4 py-2 rounded-md text-sm font-semibold shadow flex items-center gap-2">
                                <i class="fas fa-plus"></i> Tambah Rekening
                            </button>
                            <button type="button" id="cancelEditBtn" class="bg-transparent border-2 border-red-600 text-red-600 hover:bg-red-50 hover:text-red-700 transition px-4 py-2 rounded-md text-sm font-semibold hidden items-center gap-2">
                                <i class="fas fa-times"></i> Batal
                            </button>
                        </div>
                    </form>
                </div>

                {{-- List Data Rekening Bank --}}
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
                    if (typeof showLightboxCustom === 'function') {
                        showLightboxCustom(data.message, 'success', () => location.reload());
                    } else if (typeof showLightbox === 'function') {
                        showLightbox(data.message, 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        alert(data.message);
                        location.reload();
                    }
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
