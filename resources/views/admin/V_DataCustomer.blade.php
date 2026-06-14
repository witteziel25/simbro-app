@extends('layouts.V_Auth')

@section('title', 'Data Customer - SIMBRO Admin')

@section('header_title', 'Data Customer')
@section('header_desc', 'Pantau dan periksa seluruh customer yang terdaftar di SIMBRO')
@section('header_back_url', route('admin.home'))
@section('header_back_text', 'Kembali ke Beranda')

@section('content')

<div class="flex-1 bg-white">

    <div class="w-full px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header & Pencarian --}}
        <div class="card-form p-5 mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-orange-100 text-[#FF6B00] rounded-xl">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Daftar Customer</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Kelola akses dan data customer terdaftar</p>
                </div>
            </div>
            <div class="relative w-full sm:w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-search"></i>
                </div>
                <input type="text" id="searchInput" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#FF6B00]/50 focus:border-[#FF6B00] text-sm transition-all shadow-sm bg-gray-50 focus:bg-white" placeholder="Cari nama, email, hp...">
            </div>
        </div>

        {{-- Tabel Data Customer --}}
        <div class="w-full">
            @if($customers->count() > 0)
                <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/80 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Lengkap</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Username</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">No. HP</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Alamat</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Password</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($customers as $customer)
                            <tr class="transition-colors duration-200 {{ !$customer->is_active ? 'bg-red-50/80 hover:bg-red-100/50' : 'hover:bg-orange-50/50' }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ !$customer->is_active ? 'text-red-700' : 'text-gray-900' }}">#{{ $customer->user_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ !$customer->is_active ? 'text-red-800' : 'text-gray-900' }}">{{ $customer->nama_lengkap }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $customer->username }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $customer->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $customer->no_hp }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate" title="{{ $customer->alamat }}">{{ $customer->alamat }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 font-mono tracking-widest">••••••••</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                    <form action="{{ route('admin.customer.toggle', $customer->user_id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @if($customer->is_active)
                                            <button type="button" onclick="showConfirm('Yakin ingin menonaktifkan akun ini?', () => this.closest('form').submit())" class="px-3 py-1.5 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-semibold transition shadow-sm inline-flex items-center gap-1.5">
                                                <i class="fas fa-ban text-[10px]"></i> Nonaktifkan
                                            </button>
                                        @else
                                            <button type="button" onclick="showConfirm('Yakin ingin mengaktifkan akun ini?', () => this.closest('form').submit())" class="px-3 py-1.5 bg-[#FF6B00] text-white rounded hover:bg-orange-700 text-xs font-semibold transition shadow-sm inline-flex items-center gap-1.5">
                                                <i class="fas fa-check text-[10px]"></i> Aktifkan
                                            </button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="flex flex-col items-center justify-center py-16 px-4">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-400 shadow-inner">
                            <i class="fas fa-users-slash text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Belum Ada Customer</h3>
                        <p class="text-gray-500 text-sm text-center max-w-sm">Data customer yang mendaftar dan menggunakan layanan SIMBRO akan muncul di sini.</p>
                    </div>
                @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('tbody tr');

        if(searchInput) {
            searchInput.addEventListener('keyup', function(e) {
                const term = e.target.value.toLowerCase();
                
                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if(text.includes(term)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endpush
