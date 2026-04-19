@extends('layouts.auth')

@section('title', 'Data Customer - SIMBRO Admin')

@section('content')
<div class="min-h-screen py-8 px-4 md:px-12">
    <div class="max-w-7xl mx-auto mb-6">
        <a href="{{ route('admin.home') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-[#FF6B00] transition">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda Admin
        </a>
    </div>
    <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-[#FF6B00] to-orange-500 px-8 py-6">
            <h1 class="text-2xl font-bold text-white">Data Seluruh Customer</h1>
            <p class="text-orange-100">Berikut adalah daftar customer yang terdaftar di SIMBRO</p>
        </div>
        <div class="p-6 overflow-x-auto">
            @if($customers->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. HP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Password</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($customers as $customer)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $customer->user_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $customer->nama_lengkap }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $customer->username }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $customer->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $customer->no_hp }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">{{ $customer->alamat }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">••••••••</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center text-gray-500 py-8">Belum ada customer terdaftar.</p>
            @endif
        </div>
    </div>
</div>
@endsection
