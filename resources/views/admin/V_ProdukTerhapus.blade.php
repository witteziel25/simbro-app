@extends('layouts.auth')

@section('title', 'Produk Dihapus - SIMBRO Admin')

@section('content')

<div class="min-h-screen bg-white">
    <div class="bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] text-white px-6 py-6 md:px-10">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo-simbro-2.png') }}" alt="SIMBRO" class="h-12 w-auto">
                <div>
                    <h1 class="text-2xl font-bold">Produk Dihapus</h1>
                    <p class="text-orange-100 text-sm">Produk yang telah dihapus sementara. Klik Restore untuk mengembalikan.</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <a href="{{ route('admin.home') }}" class="inline-flex items-center gap-2 text-white hover:underline transition text-sm font-bold">Kembali ke Beranda Admin</a>
            </div>
        </div>
    </div>

    <div class="w-full px-4 py-8 sm:px-6 lg:px-8">
        <div class="overflow-x-auto">
            @if($produkTerhapus->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dihapus pada</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($produkTerhapus as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->produk_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->nama_produk }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->kategori }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->stok }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->deleted_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="restoreProduk({{ $item->produk_id }})" class="bg-green-600 hover:bg-green-700 text-white py-1 px-3 rounded-lg text-xs font-semibold">Restore</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center text-gray-500 py-8">Tidak ada produk yang dihapus.</div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function restoreProduk(id) {
        if (typeof showConfirm === 'function') {
            showConfirm('Yakin ingin mengembalikan produk ini?', function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('produk/restore') }}/${id}`;
                form.innerHTML = `@csrf`;
                document.body.appendChild(form);
                form.submit();
            });
        } else {
            if (confirm('Yakin ingin mengembalikan produk ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('produk/restore') }}/${id}`;
                form.innerHTML = `@csrf`;
                document.body.appendChild(form);
                form.submit();
            }
        }
    }
</script>

@endpush

@endsection
