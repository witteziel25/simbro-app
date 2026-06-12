@extends('layouts.V_Auth')

@section('title', 'Data Customer - SIMBRO Admin')

@section('header_title', 'Data Customer')
@section('header_desc', 'Pantau dan periksa seluruh customer yang terdaftar di SIMBRO')
@section('header_back_url', route('admin.home'))
@section('header_back_text', 'Kembali ke Beranda')

@section('content')

<div class="flex-1 bg-white">

    <div class="w-full px-4 py-8 sm:px-6 lg:px-8">
        {{-- Tabel Data Customer --}}
        <div class="overflow-x-auto">
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
                <div class="text-center text-gray-500 py-8">Belum ada customer terdaftar.</div>
            @endif
        </div>
    </div>
</div>

@endsection
