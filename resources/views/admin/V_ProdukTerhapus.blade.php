@extends('layouts.V_Auth')

@section('title', 'Produk Dihapus - SIMBRO Admin')

@section('header_title', 'Produk Dihapus')
@section('header_desc', 'Produk yang telah dihapus sementara. Klik Restore untuk mengembalikan.')
@section('header_back_url', route('admin.home'))
@section('header_back_text', 'Kembali ke Beranda Admin')

@section('content')

<div class="flex-1 bg-white">

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
                                <button onclick="restoreProduk({{ $item->produk_id }})" class="bg-[#FF6B00] hover:bg-orange-700 text-white py-1 px-3 rounded-md text-xs font-semibold">Restore</button>
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
